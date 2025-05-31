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
        
        <form action="{{ route('houses.by.username', $user->username) }}" method="GET">
          
            <!-- NHÓM 1: THÔNG TIN GA TÀU VÀ DI CHUYỂN -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="text-md font-medium text-gray-800 mb-3 border-b pb-2">Thông tin ga tàu và di chuyển</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                    <!-- Ga Chính -->
                    <div>
                        <label for="ga_chinh" class="block mb-2 text-sm font-medium text-gray-700">Ga chính</label>
                        <input type="text" name="ga_chinh" id="ga_chinh" 
                            value="{{ request('ga_chinh') }}"
                            class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm text-gray-700"
                            placeholder="Nhập tên ga chính">
                    </div>
                    
                    <!-- Ga Bên Cạnh -->
                    <div>
                        <label for="ga_ben_canh" class="block mb-2 text-sm font-medium text-gray-700">Ga bên cạnh</label>
                        <input type="text" name="ga_ben_canh" id="ga_ben_canh" 
                            value="{{ request('ga_ben_canh') }}"
                            class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm text-gray-700"
                            placeholder="Nhập tên ga bên cạnh">
                    </div>
                    
                    <!-- Ga Đi Tàu Tới -->
                    <div>
                        <label for="ga_di_tau_toi" class="block mb-2 text-sm font-medium text-gray-700">Ga đi tàu tới</label>
                        <input type="text" name="ga_di_tau_toi" id="ga_di_tau_toi" 
                            value="{{ request('ga_di_tau_toi') }}"
                            class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm text-gray-700"
                            placeholder="Nhập tên ga đi tàu tới">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-4">
                    <!-- Khoảng cách -->
                    <div>
                        <label for="distance" class="block mb-2 text-sm font-medium text-gray-700">Khoảng cách</label>
                        <div class="relative">
                            <input type="text" name="distance" id="distance" 
                                value="{{ request('distance') }}"
                                class="block w-full pr-12 py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm text-gray-700"
                                placeholder="Nhập khoảng cách">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500 text-sm">
                                vđ 5Phút
                            </div>
                        </div>
                    </div>
                    <!-- Phương tiện đi lại -->
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Phương tiện đi lại</label>
                        <div class="flex space-x-8">
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
                    
                    <!-- Là công ty (Chuyển từ NHÓM 3) -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Công ty</label>
                        <div>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_company" value="1" class="form-checkbox h-5 w-5 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500" {{ request('is_company') == '1' ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Hiển thị công ty</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
              <!-- NHÓM 2: THÔNG TIN NHÀ -->
              <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="text-md font-medium text-gray-800 mb-3 border-b pb-2">Thông tin nhà</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Dạng nhà -->
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
                            
                            <div class="md:col-span-2">
                                <label class="block mb-1 text-sm text-gray-600">Áp dụng cho</label>
                                <div class="grid grid-cols-2 md:grid-cols-5 gap-2">
                                  
                                    <label class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm cursor-pointer hover:bg-gray-50 {{ request('house_type_source') == 'ga_chinh' ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'text-gray-700' }}" onclick="updateHouseTypeSource(this)">
                                        <input type="radio" name="house_type_source" value="ga_chinh" class="hidden house-source-input" {{ request('house_type_source') == 'ga_chinh' ? 'checked' : '' }}>
                                        <span class="text-sm">Ga chính</span>
                                    </label>
                                    <label class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm cursor-pointer hover:bg-gray-50 {{ request('house_type_source') == 'ga_ben_canh' ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'text-gray-700' }}" onclick="updateHouseTypeSource(this)">
                                        <input type="radio" name="house_type_source" value="ga_ben_canh" class="hidden house-source-input" {{ request('house_type_source') == 'ga_ben_canh' ? 'checked' : '' }}>
                                        <span class="text-sm">Ga bên cạnh</span>
                                    </label>
                                    <label class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm cursor-pointer hover:bg-gray-50 {{ request('house_type_source') == 'ga_di_tau_toi' ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'text-gray-700' }}" onclick="updateHouseTypeSource(this)">
                                        <input type="radio" name="house_type_source" value="ga_di_tau_toi" class="hidden house-source-input" {{ request('house_type_source') == 'ga_di_tau_toi' ? 'checked' : '' }}>
                                        <span class="text-sm">Ga tàu tới</span>
                                    </label>
                                    <label class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm cursor-pointer hover:bg-gray-50 {{ request('house_type_source') == 'company' ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'text-gray-700' }}" onclick="updateHouseTypeSource(this)">
                                        <input type="radio" name="house_type_source" value="company" class="hidden house-source-input" {{ request('house_type_source') == 'company' ? 'checked' : '' }}>
                                        <span class="text-sm">Công ty</span>
                                    </label>
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
                    <!-- Giá thuê -->
                    <div>
                        <label for="min_price" class="block mb-2 text-sm font-medium text-gray-700">Giá thuê mới</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">¥</span>
                            <select name="min_price" id="min_price" 
                                class="block w-full rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-gray-700 text-sm">
                                <option value="">Chọn giá thuê</option>
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
                                <option value="20000" {{ request('input_price') == '20000' ? 'selected' : '' }}>20,000</option>
                                <option value="30000" {{ request('input_price') == '30000' ? 'selected' : '' }}>30,000</option>
                                <option value="40000" {{ request('input_price') == '40000' ? 'selected' : '' }}>40,000</option>
                                <option value="50000" {{ request('input_price') == '50000' ? 'selected' : '' }}>50,000</option>
                                <option value="60000" {{ request('input_price') == '60000' ? 'selected' : '' }}>60,000</option>
                                <option value="70000" {{ request('input_price') == '70000' ? 'selected' : '' }}>70,000</option>
                                <option value="80000" {{ request('input_price') == '80000' ? 'selected' : '' }}>80,000</option>
                                <option value="90000" {{ request('input_price') == '90000' ? 'selected' : '' }}>90,000</option>
                                <option value="100000" {{ request('input_price') == '100000' ? 'selected' : '' }}>100,000</option>
                                <option value="110000" {{ request('input_price') == '110000' ? 'selected' : '' }}>110,000</option>
                                <option value="120000" {{ request('input_price') == '120000' ? 'selected' : '' }}>120,000</option>
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
                        <div class="h-64 md:h-full relative overflow-hidden">
                            @if ($house->image_path)
                                <img src="{{ asset('storage/' . $house->image_path) }}" alt="{{ $house->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full bg-gray-100">
                                    <i class="fas fa-home text-6xl text-gray-300"></i>
                                </div>
                            @endif
                         
                        </div>
                        
                        <!-- Phần thông tin (Chiếm 2/3 bên phải khi ở màn hình lớn) -->
                        <div class="md:col-span-2 p-5">
                            <!-- Phương tiện và giá -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <!-- Thời gian đi lại -->
                                <div>
                                    <p class="text-sm text-gray-600">Thời gian đi lại:</p>
                                    <p class="font-medium text-gray-800">
                                        @php
                                            $distance = isset($house->adjusted_distance) ? $house->adjusted_distance : ($house->distance ?: '12');
                                            $distance = is_numeric($distance) ? round($distance) : $distance;
                                        @endphp
                                        {{ $distance }} phút
                                        @if ($house->transportation == 'Đi bộ')
                                            <i class="fas fa-walking ml-1 mr-1 text-indigo-700"></i> đi bộ
                                        @elseif ($house->transportation == 'Xe đạp')
                                            <i class="fas fa-bicycle ml-1 mr-1 text-indigo-700"></i> bằng xe đạp
                                        @elseif ($house->transportation == 'Tàu')
                                            <i class="fas fa-train ml-1 mr-1 text-indigo-700"></i> bằng tàu
                                        @else
                                            <i class="fas fa-walking ml-1 mr-1 text-indigo-700"></i> đi bộ
                                        @endif
                                    </p>
                                </div>
                                
                                <!-- Giá thuê -->
                                <div>
                                    <p class="text-sm text-gray-600">Giá thuê:</p>
                                    <p class="font-bold text-green-600 text-lg">
                                        @if(isset($house->adjusted_rent_price))
                                            {{ number_format($house->adjusted_rent_price) }}
                                        @else
                                            {{ number_format($house->rent_price) }}
                                        @endif
                                        <span class="text-sm font-normal">¥</span>
                                    </p>
                                    
                                    <p class="text-sm text-gray-600 mt-1">Giá đầu vào:</p>
                                    <p class="font-medium text-gray-800">
                                        @if(isset($house->adjusted_input_price))
                                            {{ number_format($house->adjusted_input_price) }}
                                        @else
                                            {{ number_format($house->input_price) }}
                                        @endif
                                        <span class="text-sm">¥</span>
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Thông tin áp dụng -->
                            <div class="mb-4 bg-gray-50 p-3 rounded-md">
                                <p class="text-sm font-medium text-gray-700 mb-2">Thông tin áp dụng:</p>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    @if (request('ga_chinh') || $house->ga_chinh)
                                    <div>
                                        <p class="text-xs text-gray-500">Ga chính:</p>
                                        <p class="text-sm font-medium text-indigo-700">{{ request('ga_chinh') ?: $house->ga_chinh }}</p>
                                    </div>
                                    @endif
                                    
                                    @if (request('ga_ben_canh') || $house->ga_ben_canh)
                                    <div>
                                        <p class="text-xs text-gray-500">Ga bên cạnh:</p>
                                        <p class="text-sm font-medium text-indigo-700">{{ request('ga_ben_canh') ?: $house->ga_ben_canh }}</p>
                                    </div>
                                    @endif
                                    
                                    @if (request('ga_di_tau_toi') || $house->ga_di_tau_toi)
                                    <div>
                                        <p class="text-xs text-gray-500">Ga đi tàu tới:</p>
                                        <p class="text-sm font-medium text-indigo-700">{{ request('ga_di_tau_toi') ?: $house->ga_di_tau_toi }}</p>
                                    </div>
                                    @endif
                                    
                                    @if (request('distance') || $house->distance)
                                    <div>
                                        <p class="text-xs text-gray-500">Khoảng cách:</p>
                                        <p class="text-sm font-medium text-indigo-700">
                                            @php
                                                $displayDistance = isset($house->adjusted_distance) ? $house->adjusted_distance : (request('distance') ?: $house->distance);
                                                $displayDistance = is_numeric($displayDistance) ? round($displayDistance) : $displayDistance;
                                            @endphp
                                            {{ $displayDistance }} phút đi bộ
                                        </p>
                                    </div>
                                    @endif
                                    
                                    @if (request('house_type') || $house->default_house_type)
                                    <div>
                                        <p class="text-xs text-gray-500">
                                            @if(request('house_type_source') == 'ga_chinh')
                                                Ga chính (Dạng nhà):
                                            @elseif(request('house_type_source') == 'ga_ben_canh')
                                                Ga bên cạnh (Dạng nhà):
                                            @elseif(request('house_type_source') == 'ga_di_tau_toi')
                                                Ga tàu tới (Dạng nhà):
                                            @elseif(request('house_type_source') == 'company')
                                                Công ty (Dạng nhà):
                                            @else
                                                Dạng nhà:
                                            @endif
                                        </p>
                                        <p class="text-sm font-medium text-indigo-700">
                                            @if(request('house_type'))
                                                {{ request('house_type') }}
                                            @elseif(request('house_type_source') == 'ga_chinh' && $house->ga_chinh_house_type)
                                                {{ $house->ga_chinh_house_type }}
                                            @elseif(request('house_type_source') == 'ga_ben_canh' && $house->ga_ben_canh_house_type)
                                                {{ $house->ga_ben_canh_house_type }}
                                            @elseif(request('house_type_source') == 'ga_di_tau_toi' && $house->ga_di_tau_toi_house_type)
                                                {{ $house->ga_di_tau_toi_house_type }}
                                            @elseif(request('house_type_source') == 'company' && $house->company_house_type)
                                                {{ $house->company_house_type }}
                                            @else
                                                {{ $house->default_house_type }}
                                            @endif
                                        </p>
                                    </div>
                                    @endif
                                    
                                    @if (request('is_company') == '1' || $house->is_company)
                                    <div>
                                        <p class="text-xs text-gray-500">Địa điểm:</p>
                                        <p class="text-sm font-medium text-indigo-700">Công ty</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                      
                            <!-- Phần nút hành động -->
                            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                                <a href="{{ route('houses.show', $house) }}" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-medium flex items-center shadow-sm transition-colors duration-200">
                                    <span>Xem chi tiết</span>
                                    <i class="fas fa-arrow-right ml-2 text-sm"></i>
                                </a>
                                
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
<script>
    function shareSearchResults() {
        // Lấy URL hiện tại
        const currentUrl = window.location.href;
        
        // Tạo URL chia sẻ từ URL hiện tại
        const shareUrl = new URL('{{ route('houses.shared.search') }}');
        
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
                alert('Đã sao chép đường dẫn chia sẻ vào clipboard!');
            })
            .catch(err => {
                console.error('Không thể sao chép: ', err);
                alert('Không thể sao chép đường dẫn. Vui lòng thử lại.');
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
</script>
@endpush 