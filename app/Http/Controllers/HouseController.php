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
    public function index(Request $request)
    {
        $query = House::query()->where('user_id', Auth::id());
        
        // Tìm kiếm
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }
        
        // Lọc theo dạng nhà
        if ($request->filled('house_type')) {
            $query->where('house_type', $request->house_type);
        }
        
        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Lọc theo khoảng giá thuê
        if ($request->filled('min_price')) {
            $query->where('rent_price', '>=', $request->min_price);
        }
        
        if ($request->filled('max_price')) {
            $query->where('rent_price', '<=', $request->max_price);
        }
        
        // Lọc theo giá đặt cọc
        if ($request->filled('deposit_price')) {
            $query->where('deposit_price', '>=', $request->deposit_price);
        }
        
        // Lọc theo khoảng cách đến ga
        if ($request->filled('distance_to_station')) {
            $distance = $request->distance_to_station;
            $query->whereRaw("JSON_EXTRACT(room_details, '$.distance_to_station') <= ?", [$distance]);
        }
        
        // Lọc theo phương tiện di chuyển
        if ($request->filled('transportation')) {
            // Chuyển đổi từ giá trị code sang tên hiển thị tiếng Việt
            $transportationValueMap = [
                'walking' => 'Đi bộ',
                'bicycle' => 'Xe đạp', 
                'train' => 'Tàu'
            ];
            
            // Chuyển đổi giá trị nếu nó là một trong các mã code (walking, bicycle, train)
            $transportation = array_key_exists($request->transportation, $transportationValueMap) 
                ? $transportationValueMap[$request->transportation] 
                : $request->transportation; // Nếu không thì giữ nguyên giá trị (trường hợp đã là tiếng Việt)
                
            $query->whereRaw("JSON_EXTRACT(room_details, '$.transportation') = ?", [$transportation]);
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
        
        $houses = $query->get();
        
        // Đếm số lượng nhà theo trạng thái
        $availableCount = House::where('user_id', Auth::id())->where('status', 'available')->count();
        $rentedCount = House::where('user_id', Auth::id())->where('status', 'rented')->count();
        
        return view('houses.index', compact('houses', 'availableCount', 'rentedCount'));
    }

    /**
     * Hiển thị danh sách nhà theo username
     */
    public function showByUsername(Request $request, $username)
    {
        // Tìm người dùng theo username
        $user = User::where('username', $username)->firstOrFail();
        
        // Chỉ cho phép chủ sở hữu xem danh sách nhà của họ
        if (Auth::id() !== $user->id) {
            abort(403, 'Bạn không có quyền xem danh sách nhà của người dùng này');
        }
        
        // Tạo query để lọc
        $query = House::query()->where('user_id', $user->id);
        
        // Tìm kiếm
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }
        
        // Lọc theo dạng nhà
        if ($request->filled('house_type')) {
            $query->where('house_type', $request->house_type);
        }
        
        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Lọc theo khoảng giá thuê
        if ($request->filled('min_price')) {
            $query->where('rent_price', '>=', $request->min_price);
        }
        
        if ($request->filled('max_price')) {
            $query->where('rent_price', '<=', $request->max_price);
        }
        
        // Lọc theo khoảng cách đến ga
        if ($request->filled('distance_to_station')) {
            $distance = $request->distance_to_station;
            $query->whereRaw("JSON_EXTRACT(room_details, '$.distance_to_station') <= ?", [$distance]);
        }
        
        // Lọc theo phương tiện di chuyển
        if ($request->filled('transportation')) {
            // Chuyển đổi từ giá trị code sang tên hiển thị tiếng Việt
            $transportationValueMap = [
                'walking' => 'Đi bộ',
                'bicycle' => 'Xe đạp', 
                'train' => 'Tàu'
            ];
            
            // Chuyển đổi giá trị nếu nó là một trong các mã code (walking, bicycle, train)
            $transportation = array_key_exists($request->transportation, $transportationValueMap) 
                ? $transportationValueMap[$request->transportation] 
                : $request->transportation; // Nếu không thì giữ nguyên giá trị (trường hợp đã là tiếng Việt)
                
            $query->whereRaw("JSON_EXTRACT(room_details, '$.transportation') = ?", [$transportation]);
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
        
        $houses = $query->get();
        
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
            'size' => 'required|numeric|min:1|max:1000',
            'rent_price' => 'required|numeric|min:0',
            'deposit_price' => 'nullable|numeric|min:0',
            'initial_cost' => 'nullable|numeric|min:0',
            'house_type' => 'required|string|in:1R,1K,1DK,1LDK,2K,2DK,2LDK,3DK,3LDK',
            'status' => 'required|in:available,rented',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'share_link' => 'nullable|string|max:255',
            
            // Các trường JSON
            'floor' => 'nullable|integer|min:1|max:50',
            'has_loft' => 'nullable|boolean',
            'nearest_station' => 'nullable|string|max:255',
            'distance_to_station' => 'nullable|numeric|min:0|max:60',
            'transportation' => 'nullable|string|in:Đi bộ,Xe đạp,Tàu',
            
            'deposit' => 'nullable|numeric|min:0',
            'key_money' => 'nullable|numeric|min:0',
            'guarantee_fee' => 'nullable|numeric|min:0',
            'insurance_fee' => 'nullable|numeric|min:0',
            'document_fee' => 'nullable|numeric|min:0',
            'parking_fee' => 'nullable|numeric|min:0',
            'rent_included' => 'nullable|boolean',
            
            'amenities' => 'nullable|array',
            'amenities.*' => 'nullable|boolean',
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
        
        // Chuẩn bị các trường JSON
        $roomDetails = [
            'floor' => $request->floor,
            'has_loft' => $request->has('has_loft') ? (bool)$request->has_loft : false,
            'nearest_station' => $request->nearest_station,
            'distance_to_station' => $request->distance_to_station,
            'transportation' => $request->transportation,
        ];
        
        $costDetails = [
            'deposit' => $request->deposit,
            'key_money' => $request->key_money,
            'guarantee_fee' => $request->guarantee_fee,
            'insurance_fee' => $request->insurance_fee,
            'document_fee' => $request->document_fee,
            'parking_fee' => $request->parking_fee,
            'rent_included' => $request->has('rent_included') ? (bool)$request->rent_included : true,
        ];
        
        // Xử lý các tiện ích từ form
        $amenities = $request->amenities ?? [];
        
        // Lọc bỏ các trường không thuộc về bảng houses
        $houseData = collect($validated)->only([
            'user_id', 'name', 'address', 'location', 'size', 'rent_price', 
            'deposit_price', 'initial_cost', 'house_type', 'status', 
            'description', 'image_path', 'share_link'
        ])->toArray();
        
        // Thêm các trường JSON
        $houseData['room_details'] = $roomDetails;
        $houseData['cost_details'] = $costDetails;
        $houseData['amenities'] = $amenities;
        
        $house = House::create($houseData);
        
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

        return redirect()->route('houses.by.username', Auth::user()->username)->with('success', 'Thêm nhà thành công');
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
            'size' => 'required|numeric|min:1|max:1000',
            'rent_price' => 'required|numeric|min:0',
            'deposit_price' => 'nullable|numeric|min:0',
            'initial_cost' => 'nullable|numeric|min:0',
            'house_type' => 'required|string|in:1R,1K,1DK,1LDK,2K,2DK,2LDK,3DK,3LDK',
            'status' => 'required|in:available,rented',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images_to_delete' => 'nullable|array',
            'images_to_delete.*' => 'nullable|integer',
            'primary_image_id' => 'nullable|integer',
            'share_link' => 'nullable|string|max:255',
            
            // Các trường JSON
            'floor' => 'nullable|integer|min:1|max:50',
            'has_loft' => 'nullable|boolean',
            'nearest_station' => 'nullable|string|max:255',
            'distance_to_station' => 'nullable|numeric|min:0|max:60',
            'transportation' => 'nullable|string|in:Đi bộ,Xe đạp,Tàu',
            
            'deposit' => 'nullable|numeric|min:0',
            'key_money' => 'nullable|numeric|min:0',
            'guarantee_fee' => 'nullable|numeric|min:0',
            'insurance_fee' => 'nullable|numeric|min:0',
            'document_fee' => 'nullable|numeric|min:0',
            'parking_fee' => 'nullable|numeric|min:0',
            'rent_included' => 'nullable|boolean',
            
            'amenities' => 'nullable|array',
            'amenities.*' => 'nullable|boolean',
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
        
        // Chuẩn bị các trường JSON
        // Lấy giá trị hiện tại
        $currentRoomDetails = $house->room_details ?? $house->getDefaultRoomDetails();
        $currentCostDetails = $house->cost_details ?? $house->getDefaultCostDetails();
        $currentAmenities = $house->amenities ?? $house->getDefaultAmenities();
        
        // Cập nhật với giá trị mới
        $roomDetails = array_merge($currentRoomDetails, [
            'floor' => $request->floor,
            'has_loft' => $request->has('has_loft') ? (bool)$request->has_loft : false,
            'nearest_station' => $request->nearest_station,
            'distance_to_station' => $request->distance_to_station,
            'transportation' => $request->transportation,
        ]);
        
        $costDetails = array_merge($currentCostDetails, [
            'deposit' => $request->deposit,
            'key_money' => $request->key_money,
            'guarantee_fee' => $request->guarantee_fee,
            'insurance_fee' => $request->insurance_fee,
            'document_fee' => $request->document_fee,
            'parking_fee' => $request->parking_fee,
            'rent_included' => $request->has('rent_included') ? (bool)$request->rent_included : true,
        ]);
        
        // Xử lý các tiện ích từ form
        $amenities = $request->amenities ?? $currentAmenities;
        
        // Lọc bỏ các trường không thuộc về bảng houses
        $houseData = collect($validated)->only([
            'name', 'address', 'location', 'size', 'rent_price', 
            'deposit_price', 'initial_cost', 'house_type', 'status', 
            'description', 'image_path', 'share_link'
        ])->toArray();
        
        // Thêm các trường JSON
        $houseData['room_details'] = $roomDetails;
        $houseData['cost_details'] = $costDetails;
        $houseData['amenities'] = $amenities;
        
        // Cập nhật thông tin nhà
        $house->update($houseData);
        
        // Xử lý upload các ảnh bổ sung
        if ($request->hasFile('additional_images')) {
            $maxOrder = $house->images()->max('sort_order') ?? 0;
            
            foreach ($request->file('additional_images') as $image) {
                $imagePath = $image->store('houses', 'public');
                $maxOrder++;
                
                $house->images()->create([
                    'image_path' => $imagePath,
                    'is_primary' => false,
                    'sort_order' => $maxOrder,
                ]);
            }
        }
        
        return redirect()->route('houses.show', $house)->with('success', 'Cập nhật nhà thành công');
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
        return view('houses.show-share', compact('house', 'images'));
    }
}