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
        // Lưu từ khóa tìm kiếm nếu có
        $searchKeyword = null;
        if ($request->filled('search')) {
            $searchKeyword = $request->search;
        }
        
        // Tạo query cơ bản
        $query = House::query()->where('user_id', Auth::id());
     
        
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
        
        // Nếu có từ khóa tìm kiếm, lấy 10 phòng ngẫu nhiên
        if ($searchKeyword) {
            $houses = $query->inRandomOrder()->limit(10)->get();
        } else {
            $houses = $query->get();
        }
        
     
        
        return view('houses.index', compact('houses', 'searchKeyword'));
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
        
        // Lưu từ khóa tìm kiếm nếu có
        $searchKeyword = null;
        if ($request->filled('search')) {
            $searchKeyword = $request->search;
        }
        
        // Tạo query cơ bản - lấy tất cả nhà của user
        $query = House::query()->where('user_id', $user->id);
     
        // Lấy tất cả nhà, không lọc theo transportation
        $houses = $query->get();
        
        // Áp dụng giá mới cho tất cả các nhà nếu có nhập giá thuê
        if ($request->filled('min_price') && $houses->count() > 0) {
            $basePrice = (float)$request->min_price;
            $increment = 1000;
            
            // Áp dụng giá mới cho tất cả nhà
            foreach ($houses as $index => $house) {
                $house->setAttribute('adjusted_rent_price', $basePrice + ($index * $increment));
            }
        }
        
        // Áp dụng giá đầu vào mới cho tất cả các nhà nếu có nhập giá đầu vào
        if ($request->filled('min_deposit') && $houses->count() > 0) {
            $baseDeposit = (float)$request->min_deposit;
            
            // Áp dụng giá đầu vào mới cho tất cả nhà
            foreach ($houses as $index => $house) {
                // Tạo giá ngẫu nhiên trong khoảng 30000-100000
                $randomAmount = rand(30000, 100000);
                $house->setAttribute('adjusted_input_price', $baseDeposit + $randomAmount);
            }
        }
        
        // Lấy lại tất cả tham số tìm kiếm để truyền cho view
        $searchParams = $request->only([
            'search', 'house_type', 'min_price', 'min_deposit', 
            'distance_to_station', 'transportation', 'sort_by', 'ga_chinh', 
            'ga_ben_canh', 'ga_di_tau_toi', 'is_company'
        ]);
        
        return view('houses.show-by-username', compact('houses', 'user', 'searchKeyword', 'searchParams'));
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
            'rent_price' => 'required|numeric|min:0',
            'input_price' => 'nullable|numeric|min:0',
            'house_type' => 'required|string|in:1r-1K,2K-2DK',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'share_link' => 'nullable|string|max:255',
            'transportation' => 'nullable|string|in:Đi bộ,Xe đạp,Tàu',
            'ga_chinh' => 'nullable|string|max:255',
            'ga_ben_canh' => 'nullable|string|max:255',
            'ga_di_tau_toi' => 'nullable|string|max:255',
            'is_company' => 'nullable|boolean',
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
       
        // Lọc bỏ các trường không thuộc về bảng houses
        $houseData = collect($validated)->only([
            'user_id', 'rent_price', 
            'input_price', 'house_type',
            'image_path', 'share_link',
            'ga_chinh', 'ga_ben_canh', 'ga_di_tau_toi',
            'is_company', 'transportation', 'distance_to_station'
        ])->toArray();
    
        
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
            'rent_price' => 'required|numeric|min:0',
            'input_price' => 'nullable|numeric|min:0',
            'house_type' => 'required|string|in:1r-1K,2K-2DK',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images_to_delete' => 'nullable|array',
            'images_to_delete.*' => 'nullable|integer',
            'primary_image_id' => 'nullable|integer',
            'share_link' => 'nullable|string|max:255',
            'transportation' => 'nullable|string|in:Đi bộ,Xe đạp,Tàu',
            'ga_chinh' => 'nullable|string|max:255',
            'ga_ben_canh' => 'nullable|string|max:255',
            'ga_di_tau_toi' => 'nullable|string|max:255',
            'is_company' => 'nullable|boolean',
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
        
        // Lọc bỏ các trường không thuộc về bảng houses
        $houseData = collect($validated)->only([
            'rent_price', 
            'input_price', 'house_type', 
            'image_path', 'share_link',
            'ga_chinh', 'ga_ben_canh', 'ga_di_tau_toi',
            'is_company', 'transportation', 'distance_to_station'
        ])->toArray();
        
        
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
     * Hiển thị kết quả tìm kiếm nhà được chia sẻ
     */
    public function sharedSearch(Request $request)
    {
        // Lấy user_id từ tham số URL
        $userId = $request->user_id;
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Không tìm thấy người dùng');
        }

        // Tìm người dùng
        $user = User::findOrFail($userId);
        
        // Lưu từ khóa tìm kiếm nếu có
        $searchKeyword = null;
        if ($request->filled('search')) {
            $searchKeyword = $request->search;
        }
        
        // Tạo query cơ bản
        $query = House::query()->where('user_id', $userId);
        
    
        // KHÔNG lọc theo giá thuê hay giá đầu vào nữa
        // Chỉ sắp xếp theo các tiêu chí khác
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
      
      
        // Lấy danh sách nhà
        $houses = $query->get();
        
        // Áp dụng giá mới cho tất cả các nhà nếu có nhập giá thuê
        if ($request->filled('min_price') && $houses->count() > 0) {
            $basePrice = (float)$request->min_price;
            $increment = 1000;
            
            // Áp dụng giá mới cho tất cả nhà
            foreach ($houses as $index => $house) {
                // Sử dụng thuộc tính động để tránh lỗi
                $house->setAttribute('adjusted_rent_price', $basePrice + ($index * $increment));
            }
        }
        
        // Áp dụng giá đầu vào mới cho tất cả các nhà nếu có nhập giá đầu vào
        if ($request->filled('min_deposit') && $houses->count() > 0) {
            $baseDeposit = (float)$request->min_deposit;
            
            // Áp dụng giá đầu vào mới cho tất cả nhà
            foreach ($houses as $index => $house) {
                // Tạo giá ngẫu nhiên trong khoảng 30000-100000
                $randomAmount = rand(30000, 100000);
                // Cộng giá đầu vào với giá ngẫu nhiên
                $house->setAttribute('adjusted_input_price', $baseDeposit + $randomAmount);
            }
        }
        
        // Lấy lại tất cả tham số tìm kiếm để truyền cho view
        $searchParams = $request->only([
            'search', 'house_type', 'min_price', 'min_deposit', 
            'distance_to_station', 'transportation', 'sort_by', 'ga_chinh', 
            'ga_ben_canh', 'ga_di_tau_toi', 'is_company'
        ]);
        
        return view('houses.shared-search', compact('houses', 'user', 'searchKeyword', 'searchParams'));
    }

    /**
     * Hiển thị thông tin nhà theo share_link (không cần đăng nhập)
     */
    public function showByShareLink($shareLink)
    {
        // Tìm nhà dựa vào share_link
        $house = House::where('share_link', $shareLink)->firstOrFail();
        
        // Lấy tất cả ảnh của nhà
        $images = $house->images;
        
        // Trả về view chi tiết nhà không yêu cầu đăng nhập
        return view('houses.share', compact('house', 'images'));
    }
}