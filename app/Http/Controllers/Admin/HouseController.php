<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\House;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HouseController extends Controller
{
    /**
     * Hiển thị danh sách nhà cho thuê
     */
    public function index(Request $request)
    {
        $query = House::query()->with('user');
        
        // Tìm kiếm
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }
        
        // Lọc theo chủ nhà
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Lọc theo dạng nhà
        if ($request->filled('house_type')) {
            $query->where('house_type', $request->house_type);
        }
        
        // Lọc theo khoảng giá
        if ($request->filled('min_price')) {
            $query->where('rent_price', '>=', $request->min_price);
        }
        
        if ($request->filled('max_price')) {
            $query->where('rent_price', '<=', $request->max_price);
        }
        
        // Sắp xếp
        switch ($request->sort_by) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'price_low':
                $query->orderBy('rent_price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('rent_price', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc'); // Mặc định: newest
        }
        
        $houses = $query->paginate(10);
        $users = User::all(); // Dùng cho dropdown lọc theo chủ nhà
        
        return view('admin.houses.index', compact('houses', 'users'));
    }

    /**
     * Hiển thị form tạo nhà mới
     */
    public function create()
    {
        $users = User::all();
        return view('admin.houses.create', compact('users'));
    }

    /**
     * Lưu nhà mới vào database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'rent_price' => ['required', 'numeric', 'min:0'],
            'deposit_price' => ['nullable', 'numeric', 'min:0'],
            'house_type' => ['required', 'in:1r,1k,1DK,2K,2DK'],
            'distance' => ['nullable', 'numeric', 'min:0'],
            'transportation' => ['nullable', 'string', 'max:255'],
            'user_id' => ['required', 'exists:users,id'],
            'status' => ['required', 'in:available,rented'],
            'image' => ['nullable', 'image', 'max:2048'],
            'additional_images.*' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->except(['image', 'additional_images']);
        
        // Xử lý upload ảnh chính nếu có
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('houses', 'public');
            $data['image_path'] = $imagePath;
        }
        
        // Tạo share_link nếu không có
        if (empty($data['share_link'])) {
            $data['share_link'] = uniqid('house_');
        }
        
        $house = House::create($data);
        
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
                'image_path' => $data['image_path'],
                'is_primary' => true,
                'sort_order' => -1, // Đặt thứ tự ưu tiên cao nhất
            ]);
        }
        
        return redirect()->route('admin.houses.index')->with('success', 'Thêm nhà cho thuê mới thành công!');
    }

    /**
     * Hiển thị chi tiết nhà
     */
    public function show(House $house)
    {
        $images = $house->images;
        return view('admin.houses.show', compact('house', 'images'));
    }

    /**
     * Hiển thị form chỉnh sửa
     */
    public function edit(House $house)
    {
        $users = User::all();
        $images = $house->images;
        return view('admin.houses.edit', compact('house', 'users', 'images'));
    }

    /**
     * Cập nhật thông tin nhà
     */
    public function update(Request $request, House $house)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'rent_price' => ['required', 'numeric', 'min:0'],
            'deposit_price' => ['nullable', 'numeric', 'min:0'],
            'house_type' => ['required', 'in:1r,1k,1DK,2K,2DK'],
            'distance' => ['nullable', 'numeric', 'min:0'],
            'transportation' => ['nullable', 'string', 'max:255'],
            'user_id' => ['required', 'exists:users,id'],
            'status' => ['required', 'in:available,rented'],
            'image' => ['nullable', 'image', 'max:2048'],
            'additional_images.*' => ['nullable', 'image', 'max:2048'],
            'images_to_delete' => ['nullable', 'array'],
            'images_to_delete.*' => ['nullable', 'integer'],
            'primary_image_id' => ['nullable', 'integer'],
        ]);

        $data = $request->except(['image', 'additional_images', 'images_to_delete', 'primary_image_id']);

        // Xử lý upload ảnh chính nếu có
        if ($request->hasFile('image')) {
            // Lưu ảnh mới
            $imagePath = $request->file('image')->store('houses', 'public');
            $data['image_path'] = $imagePath;
            
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
        
        $house->update($data);
        
        // Chuyển hướng về trang chỉnh sửa thay vì trang danh sách
        return redirect()->route('admin.houses.edit', $house)->with('success', 'Cập nhật thông tin nhà thành công');
    }

    /**
     * Xóa nhà khỏi database
     */
    public function destroy(House $house)
    {
        try {
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
            return redirect()->route('admin.houses.index')->with('success', 'Nhà cho thuê đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.houses.index')->with('error', 'Không thể xóa nhà cho thuê: ' . $e->getMessage());
        }
    }
} 