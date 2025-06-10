@extends('layouts.main')

@section('title', 'Danh sách nhà cho thuê của ' . $user->name)

@section('header')
    
@endsection

@section('content')
    <div class="mb-8">
        <div class="bg-white rounded-lg shadow p-6 flex flex-col md:flex-row gap-6 items-center">
            <div class="h-24 w-24 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white flex-shrink-0 shadow-md">
                <span class="text-4xl font-bold">{{ substr($user->name, 0, 1) }}</span>
            </div>
            
            <div class="flex-grow text-center md:text-left">
                <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
                @if ($user->phone_number)
                    <p class="text-gray-600 mt-1 flex items-center justify-center md:justify-start">
                        <i class="fas fa-phone mr-2 text-indigo-500"></i> {{ $user->phone_number }}
                    </p>
                @endif
                <p class="text-gray-600 mt-1 flex items-center justify-center md:justify-start">
                    <i class="fas fa-envelope mr-2 text-indigo-500"></i> {{ $user->email }}
                </p>
            </div>
            
            <div class="border-l border-gray-200 pl-6 hidden lg:block">
                <div class="flex items-center mb-3">
                    <div class="bg-indigo-100 rounded-full p-2 mr-3">
                        <i class="fas fa-home text-indigo-500"></i>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">Tổng số nhà</span>
                        <p class="font-bold text-gray-800 text-lg">{{ $houses->count() }}</p>
                    </div>
                </div>
            
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <i class="fas fa-filter text-indigo-600 mr-2"></i>
                <h2 class="text-lg font-medium text-gray-800">Giá trị apply</h2>
            </div>
            
            <button 
                onclick="shareSearchResults()" 
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors flex items-center shadow-sm font-medium text-sm">
                <i class="fas fa-share-alt mr-2"></i> Share Link
            </button>
        </div>
        
        <form id="applyForm" action="{{ route('houses.by.username', $user->username) }}" method="GET" onsubmit="return validateForm(event)">
          
            <!-- NHÓM 1: CHỌN VỊ TRÍ APPLY DỮ LIỆU ẢO -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="text-md font-medium text-gray-800 mb-3 border-b pb-2">Chọn vị trí apply dữ liệu</h3>
                
                <!-- Chọn loại vị trí -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Chọn 1 vị trí để apply dữ liệu:</label>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <label class="inline-flex items-center px-4 py-3 border-2 border-gray-300 rounded-lg text-sm cursor-pointer hover:bg-gray-50 {{ request('apply_location') == 'ga_chinh' ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'text-gray-700' }}" onclick="updateApplyLocation(this)">
                            <input type="radio" name="apply_location" value="ga_chinh" class="hidden apply-location-input" {{ request('apply_location') == 'ga_chinh' ? 'checked' : '' }}>
                            <i class="fas fa-train mr-2 text-indigo-600"></i>
                            <span class="font-medium">Ga chính</span>
                        </label>
                        
                        <label class="inline-flex items-center px-4 py-3 border-2 border-gray-300 rounded-lg text-sm cursor-pointer hover:bg-gray-50 {{ request('apply_location') == 'ga_ben_canh' ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'text-gray-700' }}" onclick="updateApplyLocation(this)">
                            <input type="radio" name="apply_location" value="ga_ben_canh" class="hidden apply-location-input" {{ request('apply_location') == 'ga_ben_canh' ? 'checked' : '' }}>
                            <i class="fas fa-subway mr-2 text-indigo-600"></i>
                            <span class="font-medium">Ga bên cạnh</span>
                        </label>
                        
                        <label class="inline-flex items-center px-4 py-3 border-2 border-gray-300 rounded-lg text-sm cursor-pointer hover:bg-gray-50 {{ request('apply_location') == 'ga_di_tau_toi' ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'text-gray-700' }}" onclick="updateApplyLocation(this)">
                            <input type="radio" name="apply_location" value="ga_di_tau_toi" class="hidden apply-location-input" {{ request('apply_location') == 'ga_di_tau_toi' ? 'checked' : '' }}>
                            <i class="fas fa-route mr-2 text-indigo-600"></i>
                            <span class="font-medium">Ga tàu tới</span>
                        </label>
                        
                        <label class="inline-flex items-center px-4 py-3 border-2 border-gray-300 rounded-lg text-sm cursor-pointer hover:bg-gray-50 {{ request('apply_location') == 'company' ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'text-gray-700' }}" onclick="updateApplyLocation(this)">
                            <input type="radio" name="apply_location" value="company" class="hidden apply-location-input" {{ request('apply_location') == 'company' ? 'checked' : '' }}>
                            <i class="fas fa-building mr-2 text-indigo-600"></i>
                            <span class="font-medium">Công ty</span>
                        </label>
                    </div>
                </div>
                
                <!-- Input dữ liệu tương ứng với vị trí được chọn -->
                <div id="location-inputs" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Input cho Ga Chính -->
                    <div id="ga_chinh_input" class="location-input {{ request('apply_location') == 'ga_chinh' ? '' : 'hidden' }}">
                        <label for="ga_chinh_value" class="block mb-2 text-sm font-medium text-gray-700">Tên ga chính</label>
                        <input type="text" name="ga_chinh_value" id="ga_chinh_value" 
                            value="{{ request('ga_chinh_value') }}"
                            class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm text-gray-700"
                            placeholder="Nhập tên ga chính">
                    </div>
                    
                    <!-- Input cho Ga Bên Cạnh -->
                    <div id="ga_ben_canh_input" class="location-input {{ request('apply_location') == 'ga_ben_canh' ? '' : 'hidden' }}">
                        <label for="ga_ben_canh_value" class="block mb-2 text-sm font-medium text-gray-700">Tên ga bên cạnh</label>
                        <input type="text" name="ga_ben_canh_value" id="ga_ben_canh_value" 
                            value="{{ request('ga_ben_canh_value') }}"
                            class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm text-gray-700"
                            placeholder="Nhập tên ga bên cạnh">
                    </div>
                    
                    <!-- Input cho Ga Tàu Tới -->
                    <div id="ga_di_tau_toi_input" class="location-input {{ request('apply_location') == 'ga_di_tau_toi' ? '' : 'hidden' }}">
                        <label for="ga_di_tau_toi_value" class="block mb-2 text-sm font-medium text-gray-700">Tên ga tàu tới</label>
                        <input type="text" name="ga_di_tau_toi_value" id="ga_di_tau_toi_value" 
                            value="{{ request('ga_di_tau_toi_value') }}"
                            class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm text-gray-700"
                            placeholder="Nhập tên ga tàu tới">
                    </div>
                    
                    <!-- Thông báo cho Công ty -->
                    <div id="company_input" class="location-input {{ request('apply_location') == 'company' ? '' : 'hidden' }}">
                        <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                            <p class="text-sm text-blue-700 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>
                                Đã chọn áp dụng cho Công ty. Tất cả nhà sẽ hiển thị thông tin công ty.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                    <!-- Khoảng cách -->
                    <div>
                        <label for="distance" class="block mb-2 text-sm font-medium text-gray-700">Khoảng cách</label>
                        <div class="relative">
                            <input type="text" name="distance" id="distance" 
                                value="{{ request('distance') }}"
                                class="block w-full pr-12 py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm text-gray-700"
                                placeholder="Nhập khoảng cách">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500 text-sm">
                                vd 5Phút
                            </div>
                        </div>
                    </div>
    
                    
                    <!-- Phương tiện đi lại -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Phương tiện đi lại</label>
                        <div class="flex space-x-4">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="transportation" value="walking" class="sr-only transport-input" {{ request('transportation') == 'walking' ? 'checked' : '' }}
                                    onclick="updateRadioStyle(this, 'transport')">
                                <span class="w-5 h-5 mr-2 rounded-full flex items-center justify-center {{ request('transportation') == 'walking' ? 'bg-indigo-600 border-indigo-600' : 'bg-white border border-gray-300' }}">
                                    <span class="{{ request('transportation') == 'walking' ? 'w-2 h-2 bg-white rounded-full' : '' }}"></span>
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-walking text-indigo-600 mr-2"></i>
                                    <span class="text-sm text-gray-700">Đi bộ</span>
                                </span>
                            </label>
                            
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="transportation" value="bicycle" class="sr-only transport-input" {{ request('transportation') == 'bicycle' ? 'checked' : '' }}
                                    onclick="updateRadioStyle(this, 'transport')">
                                <span class="w-5 h-5 mr-2 rounded-full flex items-center justify-center {{ request('transportation') == 'bicycle' ? 'bg-indigo-600 border-indigo-600' : 'bg-white border border-gray-300' }}">
                                    <span class="{{ request('transportation') == 'bicycle' ? 'w-2 h-2 bg-white rounded-full' : '' }}"></span>
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-bicycle text-indigo-600 mr-2"></i>
                                    <span class="text-sm text-gray-700">Xe đạp</span>
                                </span>
                            </label>
                            
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="transportation" value="train" class="sr-only transport-input" {{ request('transportation') == 'train' ? 'checked' : '' }}
                                    onclick="updateRadioStyle(this, 'transport')">
                                <span class="w-5 h-5 mr-2 rounded-full flex items-center justify-center {{ request('transportation') == 'train' ? 'bg-indigo-600 border-indigo-600' : 'bg-white border border-gray-300' }}">
                                    <span class="{{ request('transportation') == 'train' ? 'w-2 h-2 bg-white rounded-full' : '' }}"></span>
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-train text-indigo-600 mr-2"></i>
                                    <span class="text-sm text-gray-700">Tàu</span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                        </div>
            
            <!-- NHÓM 2: THÔNG TIN NHÀ -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="text-md font-medium text-gray-800 mb-3 border-b pb-2">Thông tin nhà</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Dạng nhà - chỉ có Loại phòng -->
                    <div class="md:col-span-3">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Dạng nhà</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block mb-1 text-sm text-gray-600">Loại phòng</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(['1R-1K', '2K-2DK'] as $type)
                                        <label class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm cursor-pointer hover:bg-gray-50 {{ request('house_type') == $type ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'text-gray-700' }}" onclick="updateHouseType(this)">
                                            <input type="radio" name="house_type" value="{{ $type }}" class="hidden house-type-input" {{ request('house_type') == $type ? 'checked' : '' }}>
                                            {{ $type }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- NHÓM 3: THÔNG TIN GIÁ CẢ -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="text-md font-medium text-gray-800 mb-3 border-b pb-2">Apply giá cả</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <!-- Giá tiền -->
                    <div>
                            <label for="min_price" class="block mb-2 text-sm font-medium text-gray-700">Giá tiền mới</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">¥</span>
                            <select name="min_price" id="min_price" 
                                class="block w-full rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-gray-700 text-sm">
                                <option value="">Chọn giá tiền</option>
                                <option value="20000" {{ request('min_price') == '20000' ? 'selected' : '' }}>20,000</option>
                                <option value="30000" {{ request('min_price') == '30000' ? 'selected' : '' }}>30,000</option>
                                <option value="40000" {{ request('min_price') == '40000' ? 'selected' : '' }}>40,000</option>
                                <option value="50000" {{ request('min_price') == '50000' ? 'selected' : '' }}>50,000</option>
                                <option value="60000" {{ request('min_price') == '60000' ? 'selected' : '' }}>60,000</option>
                                <option value="70000" {{ request('min_price') == '70000' ? 'selected' : '' }}>70,000</option>
                                <option value="80000" {{ request('min_price') == '80000' ? 'selected' : '' }}>80,000</option>
                                <option value="90000" {{ request('min_price') == '90000' ? 'selected' : '' }}>90,000</option>
                                <option value="100000" {{ request('min_price') == '100000' ? 'selected' : '' }}>100,000</option>
                                <option value="110000" {{ request('min_price') == '110000' ? 'selected' : '' }}>110,000</option>
                                <option value="120000" {{ request('min_price') == '120000' ? 'selected' : '' }}>120,000</option>
                            </select>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Giá sẽ tăng thêm 1000 cho mỗi nhà tiếp theo</p>
                    </div>
                    
                    <!-- Giá đầu vào -->
                    <div>
                        <label for="input_price" class="block mb-2 text-sm font-medium text-gray-700">Giá đầu vào mới</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">¥</span>
                            <select name="input_price" id="input_price"
                                class="block w-full rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-gray-700 text-sm">
                                <option value="">Chọn giá đầu vào</option>
                                <option value="60000" {{ request('input_price') == '60000' ? 'selected' : '' }}>60,000</option>
                                <option value="80000" {{ request('input_price') == '80000' ? 'selected' : '' }}>80,000</option>
                                <option value="100000" {{ request('input_price') == '100000' ? 'selected' : '' }}>100,000</option>
                                <option value="120000" {{ request('input_price') == '120000' ? 'selected' : '' }}>120,000</option>
                                <option value="140000" {{ request('input_price') == '140000' ? 'selected' : '' }}>140,000</option>
                                <option value="160000" {{ request('input_price') == '160000' ? 'selected' : '' }}>160,000</option>
                                <option value="180000" {{ request('input_price') == '180000' ? 'selected' : '' }}>180,000</option>
                                <option value="200000" {{ request('input_price') == '200000' ? 'selected' : '' }}>200,000</option>
                                <option value="220000" {{ request('input_price') == '220000' ? 'selected' : '' }}>220,000</option>
                                <option value="240000" {{ request('input_price') == '240000' ? 'selected' : '' }}>240,000</option>
                                <option value="260000" {{ request('input_price') == '260000' ? 'selected' : '' }}>260,000</option>
                                <option value="280000" {{ request('input_price') == '280000' ? 'selected' : '' }}>280,000</option>
                                <option value="300000" {{ request('input_price') == '300000' ? 'selected' : '' }}>300,000</option>
                                <option value="320000" {{ request('input_price') == '320000' ? 'selected' : '' }}>320,000</option>
                                <option value="340000" {{ request('input_price') == '340000' ? 'selected' : '' }}>340,000</option>
                                <option value="360000" {{ request('input_price') == '360000' ? 'selected' : '' }}>360,000</option>
                                <option value="380000" {{ request('input_price') == '380000' ? 'selected' : '' }}>380,000</option>
                                <option value="400000" {{ request('input_price') == '400000' ? 'selected' : '' }}>400,000</option>
                            </select>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Sẽ cộng thêm 30K-100K ngẫu nhiên</p>
                    </div>
                </div>
            </div>
            
          
            
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                 
                </div>
                
                <div class="flex space-x-3">
                    <a href="{{ route('houses.by.username', $user->username) }}" class="inline-flex items-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <i class="fas fa-undo mr-2"></i> Đặt lại
                    </a>
                    <button type="submit" class="flex items-center justify-center py-2 px-5 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 shadow-sm font-medium text-sm transition-colors">
                        <i class="fas fa-search mr-2"></i> Apply
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if ($houses->isEmpty())
        <div class="card p-12 text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/6598/6598519.png" alt="Không có nhà" class="w-32 h-32 mx-auto mb-6 opacity-50">
            <h3 class="text-xl font-bold text-gray-700">{{ $user->name }} chưa có nhà cho thuê nào</h3>
            @if (Auth::user()->id === $user->id)
                <p class="text-gray-500 my-4">Bắt đầu thêm các nhà cho thuê của bạn để quản lý dễ dàng hơn.</p>
                <a href="{{ route('houses.create') }}" class="btn-primary inline-flex items-center mt-2">
                    <i class="fas fa-plus-circle mr-2"></i> Thêm nhà mới ngay
                </a>
            @endif
        </div>
    @else
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold flex items-center">
                <span class="bg-indigo-100 text-indigo-600 p-2 rounded-md mr-3">
                    <i class="fas fa-list-ul"></i>
                </span>
                Danh sách nhà cho thuê
            </h2>
        </div>
        
        <!-- Danh sách nhà theo thiết kế mới -->
        <div class="space-y-4">
            @foreach ($houses as $house)
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                    <div class="grid grid-cols-1 md:grid-cols-3">
                        <!-- Phần ảnh nhà (Chiếm 1/3 bên trái khi ở màn hình lớn) -->
                        <div class="relative">
                            <!-- Phần ảnh chính -->
                            <div class="h-48 md:h-56 md:max-h-64 relative overflow-hidden rounded-t-lg">
                                @if ($house->image_path)
                                    <img src="{{ asset('storage/' . $house->image_path) }}" alt="{{ $house->name }}" class="w-full h-full object-contain md:object-cover object-center cursor-pointer" data-fancybox="house-{{ $house->id }}" data-caption="Ảnh chính">
                                @else
                                    <div class="flex items-center justify-center h-full bg-gray-100">
                                        <i class="fas fa-home text-6xl text-gray-300"></i>
                                    </div>
                                @endif
                                <div class="absolute top-2 right-2 bg-black bg-opacity-60 text-white rounded-full h-8 w-8 flex items-center justify-center">
                                    <span class="text-xs">1/{{ $house->images->count() > 0 ? $house->images->count() + 1 : 1 }}</span>
                                </div>
                            </div>
                            
                            <!-- Phần ảnh phụ -->
                            @if($house->images && $house->images->count() > 0)
                            <div class="flex overflow-x-auto gap-1 py-1 bg-gray-100 scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-100 rounded-b-lg">
                                <!-- Ảnh chính -->
                                <div class="flex-shrink-0 w-16 h-16">
                                    <img src="{{ asset('storage/' . $house->image_path) }}" 
                                        alt="Ảnh chính" 
                                        class="w-full h-full object-cover object-center border-2 border-indigo-500 rounded cursor-pointer" 
                                        data-fancybox="house-{{ $house->id }}"
                                        data-caption="Ảnh chính">
                                </div>
                                
                                <!-- Các ảnh phụ -->
                                @foreach($house->images as $image)
                                <div class="flex-shrink-0 w-16 h-16">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                        alt="{{ $image->caption ?? 'Ảnh phụ' }}" 
                                        class="w-full h-full object-cover object-center hover:opacity-90 rounded cursor-pointer" 
                                        data-fancybox="house-{{ $house->id }}"
                                        data-caption="{{ $image->caption ?? 'Ảnh phụ' }}">
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        
                        <!-- Phần thông tin (Chiếm 2/3 bên phải khi ở màn hình lớn) -->
                        <div class="md:col-span-2 p-5">
                            <!-- Phương tiện và giá -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <!-- Giá tiền -->
                                <div class="flex items-center gap-x-8">
    <div class="flex items-center gap-x-2">
        <p class="text-sm text-gray-600">Giá tiền:</p>
        <p class="font-bold text-green-600 text-lg">
            @if(isset($house->adjusted_rent_price))
                {{ number_format($house->adjusted_rent_price) }}
            @else
                {{ number_format($house->rent_price) }}
            @endif
            <span class="text-sm font-normal">¥</span>
        </p>
    </div>

    <div class="flex items-center gap-x-2">
        <p class="text-sm text-gray-600">Giá đầu vào:</p>
        <p class="font-medium text-gray-800 text-lg">
            @if(isset($house->adjusted_input_price))
                {{ number_format($house->adjusted_input_price) }}
            @else
                {{ number_format($house->input_price) }}
            @endif
            <span class="text-sm">¥</span>
        </p>
    </div>
</div>

                            </div>
                            
                            <!-- Thông tin nhà -->
                            <div class="mb-4 bg-gray-50 p-3 rounded-md">
                                <p class="text-sm font-medium text-gray-700 mb-2">Thông tin:</p>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    @if (request('apply_location'))
                                        @if (request('apply_location') == 'ga_chinh' && request('ga_chinh_value'))
                                        <div>
                                            <p class="text-xs text-gray-500">Ga chính:</p>
                                            <p class="text-sm font-medium text-indigo-700 flex items-center">
                                                <i class="fas fa-train mr-1"></i>
                                                {{ request('ga_chinh_value') }}
                                            </p>
                                        </div>
                                        @elseif (request('apply_location') == 'ga_ben_canh' && request('ga_ben_canh_value'))
                                        <div>
                                            <p class="text-xs text-gray-500">Ga bên cạnh:</p>
                                            <p class="text-sm font-medium text-indigo-700 flex items-center">
                                                <i class="fas fa-subway mr-1"></i>
                                                {{ request('ga_ben_canh_value') }}
                                            </p>
                                        </div>
                                        @elseif (request('apply_location') == 'ga_di_tau_toi' && request('ga_di_tau_toi_value'))
                                        <div>
                                            <p class="text-xs text-gray-500">Ga tàu tới:</p>
                                            <p class="text-sm font-medium text-indigo-700 flex items-center">
                                                <i class="fas fa-route mr-1"></i>
                                                {{ request('ga_di_tau_toi_value') }}
                                            </p>
                                        </div>
                                        @elseif (request('apply_location') == 'company')
                                        <div>
                                            <p class="text-xs text-gray-500">Địa điểm:</p>
                                            <p class="text-sm font-medium text-indigo-700 flex items-center">
                                                <i class="fas fa-building mr-1"></i>
                                                Công ty
                                            </p>
                                        </div>
                                        @endif
                                        
                                        @if (request('distance'))
                                        <div>
                                            <p class="text-xs text-gray-500">Khoảng cách:</p>
                                            <p class="text-sm font-medium text-indigo-700 flex items-center">
                                                <i class="fas fa-clock mr-1"></i>
                                                @php
                                                    $displayDistance = isset($house->adjusted_distance) ? $house->adjusted_distance : request('distance');
                                                    $displayDistance = is_numeric($displayDistance) ? round($displayDistance) : $displayDistance;
                                                    
                                                    $transportationText = 'đi bộ';
                                                    $transportationIcon = 'fa-walking';
                                                    
                                                    if (request('transportation') == 'bicycle') {
                                                        $transportationText = 'bằng xe đạp';
                                                        $transportationIcon = 'fa-bicycle';
                                                    } elseif (request('transportation') == 'train') {
                                                        $transportationText = 'bằng tàu';
                                                        $transportationIcon = 'fa-train';
                                                    }
                                                @endphp
                                                {{ $displayDistance }} phút {{ $transportationText }}
                                            </p>
                                        </div>
                                        @endif
                                        
                                        @if (request('house_type') || $house->default_house_type)
                                        <div>
                                            <p class="text-xs text-gray-500">Dạng nhà:</p>
                                            <p class="text-sm font-medium text-indigo-700 flex items-center">
                                                <i class="fas fa-home mr-1"></i>
                                                @if(request('house_type'))
                                                    {{ request('house_type') }}
                                                @else
                                                    {{ $house->default_house_type }}
                                                @endif
                                            </p>
                                        </div>
                                        @endif
                                    @else
                                        <div class="col-span-3">
                                            <div class="bg-yellow-50 border border-yellow-200 rounded-md p-3">
                                                <p class="text-sm text-yellow-700 flex items-center">
                                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                                    Chưa chọn vị trí để apply dữ liệu. Vui lòng chọn một trong 4 vị trí ở phần filter.
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                      
                            <!-- Phần nút hành động -->
                            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                                <div class="flex space-x-2">
                                    <a href="{{ route('houses.show', $house) }}" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-medium flex items-center shadow-sm transition-colors duration-200">
                                        <span>Xem chi tiết</span>
                                        <i class="fas fa-arrow-right ml-2 text-sm"></i>
                                    </a>
                                   
                                </div>
                                
                                @if (Auth::user()->id === $house->user_id)
                                <div class="space-x-2 flex items-center">
                                    <a href="{{ route('houses.edit', $house) }}" class="p-2 text-blue-500 hover:text-blue-700 hover:bg-blue-50 rounded-full transition">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('houses.destroy', $house) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-full transition" 
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa nhà này không?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection

@push('scripts')
<!-- Fancybox JS cho popup ảnh lớn -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Khởi tạo Fancybox cho gallery ảnh
        if (typeof Fancybox !== 'undefined') {
            Fancybox.bind("[data-fancybox]", {
                // Cấu hình hiển thị gallery
                Carousel: {
                    transition: "fade",
                },
                Thumbs: {
                    type: "classic",
                },
            });
        }
    });

    function shareSearchResults() {
        // Lấy URL hiện tại
        const currentUrl = window.location.href;
        
        // Tạo URL chia sẻ từ URL hiện tại
        const shareUrl = new URL(window.location.origin + '/houses/shared/search');
        
        // Lấy tất cả tham số từ URL hiện tại
        const urlParams = new URL(currentUrl).searchParams;
        
        // Thêm user_id vào URL chia sẻ
        shareUrl.searchParams.append('user_id', '{{ $user->id }}');
        
        // Thêm các tham số tìm kiếm vào URL chia sẻ
        for (const param of urlParams.entries()) {
            shareUrl.searchParams.append(param[0], param[1]);
        }
        
        // Sao chép vào clipboard
        navigator.clipboard.writeText(shareUrl.toString())
            .then(() => {
                window.toast.success('Đã sao chép đường dẫn chia sẻ vào clipboard!', 'Copy thành công');
            })
            .catch(err => {
                console.error('Không thể sao chép: ', err);
                window.toast.error('Không thể sao chép đường dẫn. Vui lòng thử lại.', 'Lỗi copy');
            });
    }

    function updateRadioStyle(inputElement, type) {
        // Reset tất cả các nút radio cùng loại
        let group = document.querySelectorAll('.' + type + '-input');
        group.forEach(input => {
            let parent = input.parentElement;
            let indicator = parent.querySelector('span:first-of-type');
            let dot = indicator.querySelector('span');
            
            // Bỏ style được chọn
            indicator.classList.remove('bg-indigo-600', 'border-indigo-600');
            indicator.classList.add('bg-white', 'border', 'border-gray-300');
            
            // Xóa dot (chấm tròn bên trong)
            if (dot) {
                dot.className = ''; // Xóa tất cả class
            }
        });
        
        // Áp dụng style cho nút được chọn
        let parent = inputElement.parentElement;
        let indicator = parent.querySelector('span:first-of-type');
        let dot = indicator.querySelector('span');
        
        // Thêm style được chọn
        indicator.classList.remove('bg-white', 'border', 'border-gray-300');
        indicator.classList.add('bg-indigo-600', 'border-indigo-600');
        
        // Thêm dot (chấm tròn bên trong)
        if (dot) {
            dot.className = 'w-2 h-2 bg-white rounded-full';
        }
        
        // Đảm bảo input radio được chọn thực sự
        inputElement.checked = true;
    }
    
    function updateHouseType(labelElement) {
        // Reset tất cả các nút dạng nhà
        let allLabels = document.querySelectorAll('input[name="house_type"]').forEach(input => {
            let label = input.parentElement;
            label.classList.remove('bg-indigo-50', 'border-indigo-500', 'text-indigo-700');
            label.classList.add('text-gray-700');
        });
        
        // Đánh dấu label được chọn
        labelElement.classList.remove('text-gray-700');
        labelElement.classList.add('bg-indigo-50', 'border-indigo-500', 'text-indigo-700');
        
        // Đảm bảo input bên trong được chọn
        let input = labelElement.querySelector('input');
        if (input) {
            input.checked = true;
        }
    }
    
    function updateHouseTypeSource(labelElement) {
        // Reset tất cả các nút nguồn dạng nhà
        let allLabels = document.querySelectorAll('input[name="house_type_source"]').forEach(input => {
            let label = input.parentElement;
            label.classList.remove('bg-indigo-50', 'border-indigo-500', 'text-indigo-700');
            label.classList.add('text-gray-700');
        });
        
        // Đánh dấu label được chọn
        labelElement.classList.remove('text-gray-700');
        labelElement.classList.add('bg-indigo-50', 'border-indigo-500', 'text-indigo-700');
        
        // Đảm bảo input bên trong được chọn
        let input = labelElement.querySelector('input');
        if (input) {
            input.checked = true;
        }
    }
    
    function updateApplyLocation(labelElement) {
        // Reset tất cả các nút apply location
        let allLabels = document.querySelectorAll('input[name="apply_location"]').forEach(input => {
            let label = input.parentElement;
            label.classList.remove('bg-indigo-50', 'border-indigo-500', 'text-indigo-700');
            label.classList.add('text-gray-700');
        });
        
        // Đánh dấu label được chọn
        labelElement.classList.remove('text-gray-700');
        labelElement.classList.add('bg-indigo-50', 'border-indigo-500', 'text-indigo-700');
        
        // Đảm bảo input bên trong được chọn
        let input = labelElement.querySelector('input');
        if (input) {
            input.checked = true;
        }
        
        // Ẩn tất cả location inputs
        let allInputs = document.querySelectorAll('.location-input');
        allInputs.forEach(input => {
            input.classList.add('hidden');
        });
        
                 // Hiển thị input tương ứng với loại được chọn
         let selectedValue = input.value;
         let targetInput = document.getElementById(selectedValue + '_input');
         if (targetInput) {
             targetInput.classList.remove('hidden');
         }
     }
     
     function shareHouseWithAppliedData(shareLink) {
         // Lấy URL hiện tại
         const currentUrl = new URL(window.location.href);
         
         // Tạo URL share cho nhà cụ thể
         const shareUrl = new URL(window.location.origin + '/share/' + shareLink);
         
         // Lấy các tham số apply từ URL hiện tại
         const applyParams = ['apply_location', 'ga_chinh_value', 'ga_ben_canh_value', 'ga_di_tau_toi_value', 'min_price', 'input_price', 'distance'];
         
         applyParams.forEach(param => {
             const value = currentUrl.searchParams.get(param);
             if (value) {
                 shareUrl.searchParams.append(param, value);
             }
         });
         
         // Sao chép vào clipboard
         navigator.clipboard.writeText(shareUrl.toString())
             .then(() => {
                 alert('Đã sao chép link chia sẻ nhà với dữ liệu vào clipboard!');
             })
             .catch(err => {
                 console.error('Không thể sao chép: ', err);
                 alert('Không thể sao chép đường dẫn. Vui lòng thử lại.');
             });
     }

     function validateForm(event) {
         // Lấy tất cả các elements cần validate
         const applyLocation = document.querySelector('input[name="apply_location"]:checked');
         const distance = document.getElementById('distance').value.trim();
         const transportation = document.querySelector('input[name="transportation"]:checked');
         const houseType = document.querySelector('input[name="house_type"]:checked');
         const minPrice = document.getElementById('min_price').value;
         const inputPrice = document.getElementById('input_price').value;
         
         let errors = [];
         
         // Validate apply location
         if (!applyLocation) {
             errors.push('• Vui lòng chọn vị trí để apply dữ liệu');
         } else {
             // Validate tên ga/công ty tương ứng với vị trí đã chọn
             const locationValue = applyLocation.value;
             if (locationValue === 'ga_chinh') {
                 const gaChinhValue = document.getElementById('ga_chinh_value').value.trim();
                 if (!gaChinhValue) {
                     errors.push('• Vui lòng nhập tên ga chính');
                 }
             } else if (locationValue === 'ga_ben_canh') {
                 const gaBenCanhValue = document.getElementById('ga_ben_canh_value').value.trim();
                 if (!gaBenCanhValue) {
                     errors.push('• Vui lòng nhập tên ga bên cạnh');
                 }
             } else if (locationValue === 'ga_di_tau_toi') {
                 const gaDiTauToiValue = document.getElementById('ga_di_tau_toi_value').value.trim();
                 if (!gaDiTauToiValue) {
                     errors.push('• Vui lòng nhập tên ga tàu tới');
                 }
             }
             // Không cần validate cho company vì nó tự động
         }
         
         // Validate distance
         if (!distance) {
             errors.push('• Vui lòng nhập khoảng cách');
         } else if (isNaN(distance) || distance <= 0) {
             errors.push('• Khoảng cách phải là số dương');
         }
         
         // Validate transportation
         if (!transportation) {
             errors.push('• Vui lòng chọn phương tiện di chuyển');
         }
         
         // Validate house type
         if (!houseType) {
             errors.push('• Vui lòng chọn loại phòng');
         }
         
         // Validate min price
         if (!minPrice) {
             errors.push('• Vui lòng chọn giá tiền mới');
         }
         
         // Validate input price
         if (!inputPrice) {
             errors.push('• Vui lòng chọn giá đầu vào mới');
         }
         
         // Nếu có lỗi, hiển thị thông báo và ngăn form submit
         if (errors.length > 0) {
             event.preventDefault();
             alert('Vui lòng điền đầy đủ thông tin:\n\n' + errors.join('\n'));
             return false;
         }
         
         return true;
     }
</script>
@endpush 