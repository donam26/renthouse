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
     * Tính giá thuê ảo dựa trên house ID để đảm bảo giá trị nhất quán
     */
    private function calculateVirtualRentPrice($houseId, $basePrice)
    {
        // Sử dụng house ID để tạo seed cho random, đảm bảo giá trị nhất quán
        mt_srand($houseId + 12345); // Thêm offset để tránh seed = 0
        $randomAmount = mt_rand(1000, 10000);
        // Làm tròn đến đơn vị 1000
        return round(($basePrice + $randomAmount) / 1000) * 1000;
    }

    /**
     * Tính giá đầu vào ảo dựa trên house ID để đảm bảo giá trị nhất quán
     */
    private function calculateVirtualInputPrice($houseId, $basePrice)
    {
        // Sử dụng house ID với offset khác để có giá trị khác với rent price
        mt_srand($houseId + 67890);
        $randomAmount = mt_rand(30000, 100000);
        // Làm tròn đến đơn vị 1000
        return round(($basePrice + $randomAmount) / 1000) * 1000;
    }

    /**
     * Tính khoảng cách ảo dựa trên house ID để đảm bảo giá trị nhất quán
     */
    private function calculateVirtualDistance($houseId, $baseDistance)
    {
        // Sử dụng house ID với offset cho khoảng cách
        mt_srand($houseId + 99999);
        $randomMinutes = mt_rand(1, 10);
        return $baseDistance + $randomMinutes;
    }

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
        
        // Lọc theo kiểu phòng nếu có
        $selectedHouseType = $request->house_type;
        $selectedSource = $request->house_type_source;

        if ($selectedHouseType && $selectedSource) {
            switch ($selectedSource) {
                case 'ga_chinh':
                    $query->where('ga_chinh_house_type', $selectedHouseType);
                    break;
                case 'ga_ben_canh':
                    $query->where('ga_ben_canh_house_type', $selectedHouseType);
                    break;
                case 'ga_di_tau_toi':
                    $query->where('ga_di_tau_toi_house_type', $selectedHouseType);
                    break;
                case 'company':
                    $query->where('company_house_type', $selectedHouseType);
                    break;
                default:
                    $query->where('default_house_type', $selectedHouseType);
                    break;
            }
        } elseif ($selectedHouseType) {
            // Nếu chỉ có house_type mà không có source, tìm trong tất cả các trường
            $query->where(function($q) use ($selectedHouseType) {
                $q->where('default_house_type', $selectedHouseType)
                  ->orWhere('ga_chinh_house_type', $selectedHouseType)
                  ->orWhere('ga_ben_canh_house_type', $selectedHouseType)
                  ->orWhere('ga_di_tau_toi_house_type', $selectedHouseType)
                  ->orWhere('company_house_type', $selectedHouseType);
            });
        }
        
        // Lấy tất cả nhà, không lọc theo transportation
        $houses = $query->get();
        
        // Xác định vị trí apply dữ liệu ảo (chỉ được chọn 1 trong 4 loại)
        $applyLocation = $request->apply_location; // ga_chinh, ga_ben_canh, ga_di_tau_toi, company
        
        // Áp dụng giá mới cho tất cả các nhà nếu có nhập giá thuê và chọn vị trí apply
        if ($request->filled('min_price') && $applyLocation && $houses->count() > 0) {
            $basePrice = (float)$request->min_price;
            
            // Áp dụng giá mới cho tất cả nhà
            foreach ($houses as $index => $house) {
                $adjustedRentPrice = $this->calculateVirtualRentPrice($house->id, $basePrice);
                $house->setAttribute('adjusted_rent_price', $adjustedRentPrice);
            }
        }
        
        // Áp dụng giá đầu vào mới cho tất cả các nhà nếu có nhập giá đầu vào và chọn vị trí apply
        if ($request->filled('input_price') && $applyLocation && $houses->count() > 0) {
            $baseDeposit = (float)$request->input_price;
            
            // Áp dụng giá đầu vào mới cho tất cả nhà
            foreach ($houses as $index => $house) {
                $adjustedInputPrice = $this->calculateVirtualInputPrice($house->id, $baseDeposit);
                $house->setAttribute('adjusted_input_price', $adjustedInputPrice);
            }
        }
        
        // Áp dụng số phút di chuyển ngẫu nhiên nếu có nhập khoảng cách và chọn vị trí apply
        if ($request->filled('distance') && $applyLocation && $houses->count() > 0) {
            $baseDistance = (int)$request->distance;
            
            // Áp dụng khoảng cách mới cho tất cả nhà
            foreach ($houses as $house) {
                $adjustedDistance = $this->calculateVirtualDistance($house->id, $baseDistance);
                $house->setAttribute('adjusted_distance', $adjustedDistance);
            }
        }
        
        // Áp dụng dữ liệu ảo cho vị trí được chọn
        if ($applyLocation && $houses->count() > 0) {
            foreach ($houses as $house) {
                switch ($applyLocation) {
                    case 'ga_chinh':
                        if ($request->filled('ga_chinh_value')) {
                            $house->setAttribute('applied_ga_chinh', $request->ga_chinh_value);
                        }
                        break;
                    case 'ga_ben_canh':
                        if ($request->filled('ga_ben_canh_value')) {
                            $house->setAttribute('applied_ga_ben_canh', $request->ga_ben_canh_value);
                        }
                        break;
                    case 'ga_di_tau_toi':
                        if ($request->filled('ga_di_tau_toi_value')) {
                            $house->setAttribute('applied_ga_di_tau_toi', $request->ga_di_tau_toi_value);
                        }
                        break;
                    case 'company':
                        $house->setAttribute('applied_is_company', true);
                        break;
                }
            }
        }
        
        // Lấy lại tất cả tham số tìm kiếm để truyền cho view
        $searchParams = $request->only([
            'search', 'house_type', 'house_type_source', 'min_price', 'input_price', 
            'distance', 'transportation', 'sort_by', 'apply_location',
            'ga_chinh_value', 'ga_ben_canh_value', 'ga_di_tau_toi_value'
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
        // Kiểm tra xem đã chọn loại vị trí chưa
        if (!$request->has('location_type')) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['location_type' => 'Vui lòng chọn một loại vị trí']);
        }

        // Chuẩn bị validation cơ bản
        $baseRules = [
            'location_type' => 'required|in:ga_chinh,ga_ben_canh,ga_di_tau_toi,company',
            'rent_price' => 'required|numeric|min:0',
            'input_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'share_link' => 'nullable|string|max:255',
            'transportation' => 'nullable|string|in:Đi bộ,Xe đạp,Tàu',
            'description' => 'nullable|string',
            'distance' => 'nullable|integer|min:0',
        ];

        // Bổ sung rules tùy theo loại vị trí được chọn
        $locationType = $request->input('location_type');
        
        if ($locationType === 'ga_chinh') {
            $baseRules['ga_chinh'] = 'required|string|max:255';
            $baseRules['ga_chinh_house_type'] = 'required|string|in:1R-1K,2K-2DK';
        } else if ($locationType === 'ga_ben_canh') {
            $baseRules['ga_ben_canh'] = 'required|string|max:255';
            $baseRules['ga_ben_canh_house_type'] = 'required|string|in:1R-1K,2K-2DK';
        } else if ($locationType === 'ga_di_tau_toi') {
            $baseRules['ga_di_tau_toi'] = 'required|string|max:255';
            $baseRules['ga_di_tau_toi_house_type'] = 'required|string|in:1R-1K,2K-2DK';
        } else if ($locationType === 'company') {
            $baseRules['is_company'] = 'required|boolean';
            $baseRules['company_house_type'] = 'required|string|in:1R-1K,2K-2DK';
        }

        // Validate dữ liệu
        $validated = $request->validate($baseRules);

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
        
        // Sử dụng loại nhà được chọn làm default_house_type
        if ($locationType === 'ga_chinh') {
            $validated['default_house_type'] = $validated['ga_chinh_house_type'];
        } else if ($locationType === 'ga_ben_canh') {
            $validated['default_house_type'] = $validated['ga_ben_canh_house_type'];
        } else if ($locationType === 'ga_di_tau_toi') {
            $validated['default_house_type'] = $validated['ga_di_tau_toi_house_type'];
        } else if ($locationType === 'company') {
            $validated['default_house_type'] = $validated['company_house_type'];
        }
       
        // Lọc bỏ các trường không thuộc về bảng houses
        $houseData = collect($validated)->only([
            'user_id', 'rent_price', 'input_price', 'default_house_type',
            'ga_chinh', 'ga_chinh_house_type',
            'ga_ben_canh', 'ga_ben_canh_house_type',
            'ga_di_tau_toi', 'ga_di_tau_toi_house_type',
            'is_company', 'company_house_type',
            'image_path', 'share_link', 'description',
            'transportation', 'distance'
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
        // Kiểm tra quyền sở hữu
        if (Auth::id() !== $house->user_id) {
            abort(403, 'Bạn không có quyền chỉnh sửa nhà này');
        }

        // Kiểm tra xem đã chọn loại vị trí chưa
        if (!$request->has('location_type')) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['location_type' => 'Vui lòng chọn một loại vị trí']);
        }

        // Chuẩn bị validation cơ bản
        $baseRules = [
            'location_type' => 'required|in:ga_chinh,ga_ben_canh,ga_di_tau_toi,company',
            'rent_price' => 'required|numeric|min:0',
            'input_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'share_link' => 'nullable|string|max:255',
            'transportation' => 'nullable|string|in:Đi bộ,Xe đạp,Tàu',
            'description' => 'nullable|string',
            'distance' => 'nullable|integer|min:0',
        ];

        // Bổ sung rules tùy theo loại vị trí được chọn
        $locationType = $request->input('location_type');
        
        if ($locationType === 'ga_chinh') {
            $baseRules['ga_chinh'] = 'required|string|max:255';
            $baseRules['ga_chinh_house_type'] = 'required|string|in:1R-1K,2K-2DK';
        } else if ($locationType === 'ga_ben_canh') {
            $baseRules['ga_ben_canh'] = 'required|string|max:255';
            $baseRules['ga_ben_canh_house_type'] = 'required|string|in:1R-1K,2K-2DK';
        } else if ($locationType === 'ga_di_tau_toi') {
            $baseRules['ga_di_tau_toi'] = 'required|string|max:255';
            $baseRules['ga_di_tau_toi_house_type'] = 'required|string|in:1R-1K,2K-2DK';
        } else if ($locationType === 'company') {
            $baseRules['is_company'] = 'required|boolean';
            $baseRules['company_house_type'] = 'required|string|in:1R-1K,2K-2DK';
        }

        // Validate dữ liệu
        $validated = $request->validate($baseRules);

        // Khởi tạo mảng dữ liệu cập nhật
        $houseData = [];

        // Thêm dữ liệu cơ bản
        $houseData['rent_price'] = $validated['rent_price'];
        $houseData['input_price'] = $validated['input_price'] ?? null;
        $houseData['share_link'] = $validated['share_link'] ?? $house->share_link;
        $houseData['description'] = $validated['description'] ?? null;
        $houseData['transportation'] = $validated['transportation'] ?? 'Đi bộ';
        $houseData['distance'] = $validated['distance'] ?? null;

        // Xử lý dữ liệu dựa trên loại vị trí
        if ($locationType === 'ga_chinh') {
            $houseData['ga_chinh'] = $validated['ga_chinh'];
            $houseData['ga_chinh_house_type'] = $validated['ga_chinh_house_type'];
            $houseData['default_house_type'] = $validated['ga_chinh_house_type'];
            // Reset các trường khác nếu cần
            $houseData['ga_ben_canh'] = null;
            $houseData['ga_ben_canh_house_type'] = null;
            $houseData['ga_di_tau_toi'] = null;
            $houseData['ga_di_tau_toi_house_type'] = null;
            $houseData['is_company'] = false;
            $houseData['company_house_type'] = null;
        } 
        else if ($locationType === 'ga_ben_canh') {
            $houseData['ga_ben_canh'] = $validated['ga_ben_canh'];
            $houseData['ga_ben_canh_house_type'] = $validated['ga_ben_canh_house_type'];
            $houseData['default_house_type'] = $validated['ga_ben_canh_house_type'];
            // Reset các trường khác
            $houseData['ga_chinh'] = null;
            $houseData['ga_chinh_house_type'] = null;
            $houseData['ga_di_tau_toi'] = null;
            $houseData['ga_di_tau_toi_house_type'] = null;
            $houseData['is_company'] = false;
            $houseData['company_house_type'] = null;
        } 
        else if ($locationType === 'ga_di_tau_toi') {
            $houseData['ga_di_tau_toi'] = $validated['ga_di_tau_toi'];
            $houseData['ga_di_tau_toi_house_type'] = $validated['ga_di_tau_toi_house_type'];
            $houseData['default_house_type'] = $validated['ga_di_tau_toi_house_type'];
            // Reset các trường khác
            $houseData['ga_chinh'] = null;
            $houseData['ga_chinh_house_type'] = null;
            $houseData['ga_ben_canh'] = null;
            $houseData['ga_ben_canh_house_type'] = null;
            $houseData['is_company'] = false;
            $houseData['company_house_type'] = null;
        } 
        else if ($locationType === 'company') {
            $houseData['is_company'] = true;
            $houseData['company_house_type'] = $validated['company_house_type'];
            $houseData['default_house_type'] = $validated['company_house_type'];
            // Reset các trường khác
            $houseData['ga_chinh'] = null;
            $houseData['ga_chinh_house_type'] = null;
            $houseData['ga_ben_canh'] = null;
            $houseData['ga_ben_canh_house_type'] = null;
            $houseData['ga_di_tau_toi'] = null;
            $houseData['ga_di_tau_toi_house_type'] = null;
        }

        // Xử lý upload ảnh chính mới nếu có
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($house->image_path && Storage::disk('public')->exists($house->image_path)) {
                Storage::disk('public')->delete($house->image_path);
            }
            
            // Lưu ảnh mới
            $imagePath = $request->file('image')->store('houses', 'public');
            $houseData['image_path'] = $imagePath;
            
            // Tạo hoặc cập nhật bản ghi house_image cho ảnh chính
            $house->images()
                ->where('is_primary', true)
                ->delete(); // Xóa ảnh chính cũ
                
            $house->images()->create([
                'image_path' => $imagePath,
                'is_primary' => true,
                'sort_order' => -1,
            ]);
        }

        // Xử lý upload ảnh bổ sung nếu có
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $index => $image) {
                $imagePath = $image->store('houses', 'public');
                
                $house->images()->create([
                    'image_path' => $imagePath,
                    'is_primary' => false,
                    'sort_order' => $index,
                ]);
            }
        }

        // Cập nhật nhà
        $house->update($houseData);

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

        return redirect()->route('houses.by.username', Auth::user()->username)->with('success', 'Xóa nhà thành công');
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
        
        // Lấy media của chủ nhà
        $videos = $user->videos()->limit(2)->get(); // Giới hạn 2 video
        $licenses = $user->licenses()->limit(4)->get(); // Giới hạn 4 ảnh giấy phép
        $interactions = $user->interactions()->limit(10)->get(); // Lấy 10 ảnh tương tác
        
        // Lưu từ khóa tìm kiếm nếu có
        $searchKeyword = null;
        if ($request->filled('search')) {
            $searchKeyword = $request->search;
        }
        
        // Tạo query cơ bản
        $query = House::query()->where('user_id', $userId);
        
        // Lọc theo kiểu phòng nếu có
        $selectedHouseType = $request->house_type;
        $selectedSource = $request->house_type_source;

        if ($selectedHouseType && $selectedSource) {
            switch ($selectedSource) {
                case 'ga_chinh':
                    $query->where('ga_chinh_house_type', $selectedHouseType);
                    break;
                case 'ga_ben_canh':
                    $query->where('ga_ben_canh_house_type', $selectedHouseType);
                    break;
                case 'ga_di_tau_toi':
                    $query->where('ga_di_tau_toi_house_type', $selectedHouseType);
                    break;
                case 'company':
                    $query->where('company_house_type', $selectedHouseType);
                    break;
                default:
                    $query->where('default_house_type', $selectedHouseType);
                    break;
            }
        } elseif ($selectedHouseType) {
            // Nếu chỉ có house_type mà không có source, tìm trong tất cả các trường
            $query->where(function($q) use ($selectedHouseType) {
                $q->where('default_house_type', $selectedHouseType)
                  ->orWhere('ga_chinh_house_type', $selectedHouseType)
                  ->orWhere('ga_ben_canh_house_type', $selectedHouseType)
                  ->orWhere('ga_di_tau_toi_house_type', $selectedHouseType)
                  ->orWhere('company_house_type', $selectedHouseType);
            });
        }
    
        // KHÔNG lọc theo giá thuê hay giá đầu vào nữa
      
      
        // Lấy danh sách nhà
        $houses = $query->get();
        
        // Xác định vị trí apply dữ liệu ảo (chỉ được chọn 1 trong 4 loại)
        $applyLocation = $request->apply_location; // ga_chinh, ga_ben_canh, ga_di_tau_toi, company
        
        // Áp dụng giá mới cho tất cả các nhà nếu có nhập giá thuê và chọn vị trí apply
        if ($request->filled('min_price') && $applyLocation && $houses->count() > 0) {
            $basePrice = (float)$request->min_price;
            
            // Áp dụng giá mới cho tất cả nhà
            foreach ($houses as $index => $house) {
                $adjustedRentPrice = $this->calculateVirtualRentPrice($house->id, $basePrice);
                $house->setAttribute('adjusted_rent_price', $adjustedRentPrice);
            }
        }
        
        // Áp dụng giá đầu vào mới cho tất cả các nhà nếu có nhập giá đầu vào và chọn vị trí apply
        if ($request->filled('input_price') && $applyLocation && $houses->count() > 0) {
            $baseDeposit = (float)$request->input_price;
            
            // Áp dụng giá đầu vào mới cho tất cả nhà
            foreach ($houses as $index => $house) {
                $adjustedInputPrice = $this->calculateVirtualInputPrice($house->id, $baseDeposit);
                $house->setAttribute('adjusted_input_price', $adjustedInputPrice);
            }
        }
        
        // Áp dụng số phút di chuyển ngẫu nhiên nếu có nhập khoảng cách và chọn vị trí apply
        if ($request->filled('distance') && $applyLocation && $houses->count() > 0) {
            $baseDistance = (int)$request->distance;
            
            // Áp dụng khoảng cách mới cho tất cả nhà
            foreach ($houses as $house) {
                $adjustedDistance = $this->calculateVirtualDistance($house->id, $baseDistance);
                $house->setAttribute('adjusted_distance', $adjustedDistance);
            }
        }
        
        // Áp dụng dữ liệu ảo cho vị trí được chọn
        if ($applyLocation && $houses->count() > 0) {
            foreach ($houses as $house) {
                switch ($applyLocation) {
                    case 'ga_chinh':
                        if ($request->filled('ga_chinh_value')) {
                            $house->setAttribute('applied_ga_chinh', $request->ga_chinh_value);
                        }
                        break;
                    case 'ga_ben_canh':
                        if ($request->filled('ga_ben_canh_value')) {
                            $house->setAttribute('applied_ga_ben_canh', $request->ga_ben_canh_value);
                        }
                        break;
                    case 'ga_di_tau_toi':
                        if ($request->filled('ga_di_tau_toi_value')) {
                            $house->setAttribute('applied_ga_di_tau_toi', $request->ga_di_tau_toi_value);
                        }
                        break;
                    case 'company':
                        $house->setAttribute('applied_is_company', true);
                        break;
                }
            }
        }
        
        // Lấy lại tất cả tham số tìm kiếm để truyền cho view
        $searchParams = $request->only([
            'search', 'house_type', 'house_type_source', 'min_price', 'input_price', 
            'distance', 'transportation', 'sort_by', 'apply_location',
            'ga_chinh_value', 'ga_ben_canh_value', 'ga_di_tau_toi_value'
        ]);
        
        return view('houses.shared-search', compact('houses', 'user', 'searchKeyword', 'searchParams', 'videos', 'licenses', 'interactions'));
    }

    /**
     * Hiển thị thông tin nhà theo share_link (không cần đăng nhập)
     */
    public function showByShareLink(Request $request, $shareLink)
    {
        // Tìm nhà dựa vào share_link
        $house = House::where('share_link', $shareLink)->firstOrFail();
        
        // Lấy tất cả ảnh của nhà
        $images = $house->images;
        
        // Lấy media của chủ nhà
        $user = $house->user;
        $videos = $user->videos()->limit(2)->get(); // Giới hạn 2 video
        $licenses = $user->licenses()->limit(4)->get(); // Giới hạn 4 ảnh giấy phép
        $interactions = $user->interactions()->limit(10)->get(); // Lấy 10 ảnh tương tác
        
        // Xử lý dữ liệu ảo từ URL parameters
        $applyLocation = $request->apply_location;
        
        // Áp dụng giá thuê ảo nếu có
        if ($request->filled('min_price') && $applyLocation) {
            $basePrice = (float)$request->min_price;
            $adjustedRentPrice = $this->calculateVirtualRentPrice($house->id, $basePrice);
            $house->setAttribute('adjusted_rent_price', $adjustedRentPrice);
        }
        
        // Áp dụng giá đầu vào ảo nếu có
        if ($request->filled('input_price') && $applyLocation) {
            $baseDeposit = (float)$request->input_price;
            $adjustedInputPrice = $this->calculateVirtualInputPrice($house->id, $baseDeposit);
            $house->setAttribute('adjusted_input_price', $adjustedInputPrice);
        }
        
        // Áp dụng khoảng cách ảo nếu có
        if ($request->filled('distance') && $applyLocation) {
            $baseDistance = (int)$request->distance;
            $adjustedDistance = $this->calculateVirtualDistance($house->id, $baseDistance);
            $house->setAttribute('adjusted_distance', $adjustedDistance);
        }
        
        // Áp dụng dữ liệu ảo cho vị trí được chọn
        if ($applyLocation) {
            switch ($applyLocation) {
                case 'ga_chinh':
                    if ($request->filled('ga_chinh_value')) {
                        $house->setAttribute('applied_ga_chinh', $request->ga_chinh_value);
                    }
                    break;
                case 'ga_ben_canh':
                    if ($request->filled('ga_ben_canh_value')) {
                        $house->setAttribute('applied_ga_ben_canh', $request->ga_ben_canh_value);
                    }
                    break;
                case 'ga_di_tau_toi':
                    if ($request->filled('ga_di_tau_toi_value')) {
                        $house->setAttribute('applied_ga_di_tau_toi', $request->ga_di_tau_toi_value);
                    }
                    break;
                case 'company':
                    $house->setAttribute('applied_is_company', true);
                    break;
            }
        }
        
        // Lấy tất cả tham số để truyền cho view
        $searchParams = $request->only([
            'apply_location', 'ga_chinh_value', 'ga_ben_canh_value', 
            'ga_di_tau_toi_value', 'min_price', 'input_price', 'distance'
        ]);
        
        // Trả về view chi tiết nhà không yêu cầu đăng nhập
        return view('houses.share', compact('house', 'images', 'videos', 'licenses', 'interactions', 'searchParams'));
    }
}