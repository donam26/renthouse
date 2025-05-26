<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $houses = Auth::user()->houses;
        return view('houses.index', compact('houses'));
    }

    /**
     * Hiển thị danh sách nhà theo username
     */
    public function showByUsername($username)
    {
        // Tìm người dùng theo username
        $user = User::where('username', $username)->firstOrFail();
        
        // Chỉ cho phép chủ sở hữu xem danh sách nhà của họ
        if (Auth::id() !== $user->id) {
            abort(403, 'Bạn không có quyền xem danh sách nhà của người dùng này');
        }
        
        $houses = $user->houses;
        
        return view('houses.show-by-username', compact('houses', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('houses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'distance' => 'nullable|numeric|between:0,99999999.99',
            'transportation' => 'nullable|string|max:255',
            'rent_price' => 'required|numeric',
            'deposit_price' => 'nullable|numeric',
            'house_type' => 'nullable|string|in:1r,1k,1DK,2K,2DK,3DK',
            'status' => 'required|in:available,rented',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'share_link' => 'nullable|string|max:255',
        ]);

        // Xử lý upload file ảnh chính
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('houses', 'public');
            $validated['image_path'] = $imagePath;
        }

        // Gán user_id cho nhà mới
        $validated['user_id'] = Auth::id();
        
        // Tạo share_link nếu không có
        if (empty($validated['share_link'])) {
            $validated['share_link'] = uniqid('house_');
        }

        $house = House::create($validated);
        
        // Xử lý upload các ảnh bổ sung
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $index => $image) {
                $imagePath = $image->store('houses', 'public');
                
                // Ảnh đầu tiên trong danh sách là ảnh chính nếu không có ảnh chính
                $isPrimary = !$request->hasFile('image') && $index === 0;
                
                $house->images()->create([
                    'image_path' => $imagePath,
                    'is_primary' => $isPrimary,
                    'sort_order' => $index,
                ]);
            }
        }
        
        // Nếu có ảnh chính từ trường image, tạo bản ghi house_image tương ứng
        if ($request->hasFile('image')) {
            $house->images()->create([
                'image_path' => $validated['image_path'],
                'is_primary' => true,
                'sort_order' => -1, // Đặt thứ tự ưu tiên cao nhất
            ]);
        }

        return redirect()->route('houses.index')->with('success', 'Thêm nhà thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(House $house)
    {
        $this->authorize('view', $house);
        $images = $house->images;
        return view('houses.show', compact('house', 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(House $house)
    {
        $this->authorize('update', $house);
        $images = $house->images;
        return view('houses.edit', compact('house', 'images'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, House $house)
    {
        $this->authorize('update', $house);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'distance' => 'nullable|numeric|between:0,99999999.99',
            'transportation' => 'nullable|string|max:255',
            'rent_price' => 'required|numeric',
            'deposit_price' => 'nullable|numeric',
            'house_type' => 'nullable|string|in:1r,1k,1DK,2K,2DK,3DK',
            'status' => 'required|in:available,rented',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images_to_delete' => 'nullable|array',
            'images_to_delete.*' => 'nullable|integer',
            'primary_image_id' => 'nullable|integer',
            'share_link' => 'nullable|string|max:255',
        ]);

        // Xử lý upload file ảnh mới
        if ($request->hasFile('image')) {
            // Lưu ảnh mới
            $imagePath = $request->file('image')->store('houses', 'public');
            $validated['image_path'] = $imagePath;
            
            // Tạo bản ghi ảnh mới và đặt làm ảnh chính
            $house->images()->where('is_primary', true)->update(['is_primary' => false]);
            $house->images()->create([
                'image_path' => $imagePath,
                'is_primary' => true,
                'sort_order' => -1,
            ]);
        } else if ($request->has('primary_image_id')) {
            // Cập nhật ảnh chính nếu được chọn
            $house->images()->where('is_primary', true)->update(['is_primary' => false]);
            $house->images()->where('id', $request->primary_image_id)->update(['is_primary' => true]);
        }
        
        // Xóa các ảnh được chọn để xóa
        if ($request->has('images_to_delete')) {
            $imagesToDelete = $house->images()->whereIn('id', $request->images_to_delete)->get();
            
            foreach ($imagesToDelete as $image) {
                // Xóa file ảnh
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
                
                // Xóa bản ghi
                $image->delete();
            }
        }
        
        // Xử lý upload các ảnh bổ sung
        if ($request->hasFile('additional_images')) {
            $maxOrder = $house->images()->max('sort_order') ?? 0;
            
            foreach ($request->file('additional_images') as $index => $image) {
                $imagePath = $image->store('houses', 'public');
                $maxOrder++;
                
                $house->images()->create([
                    'image_path' => $imagePath,
                    'is_primary' => false,
                    'sort_order' => $maxOrder,
                ]);
            }
        }
        
        // Tạo share_link nếu không có
        if (empty($validated['share_link'])) {
            $validated['share_link'] = uniqid('house_');
        }

        $house->update($validated);

        // Chuyển hướng về trang chỉnh sửa thay vì trang danh sách
        return redirect()->route('houses.edit', $house)->with('success', 'Cập nhật thông tin nhà thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(House $house)
    {
        $this->authorize('delete', $house);

        // Xóa tất cả ảnh liên quan
        foreach ($house->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        }
        
        // Xóa ảnh chính (nếu có)
        if ($house->image_path) {
            Storage::disk('public')->delete($house->image_path);
        }

        $house->delete();

        return redirect()->route('houses.index')->with('success', 'Xóa nhà thành công');
    }

    /**
     * Hiển thị chi tiết nhà thông qua share_link
     */
    public function showByShareLink(Request $request, $shareLink)
    {
        // Tìm nhà theo share_link
        $house = House::where('share_link', $shareLink)->firstOrFail();
        $images = $house->images;
        
        // Không kiểm tra authorize ở đây để cho phép truy cập công khai
        return view('houses.show', compact('house', 'images'));
    }
}