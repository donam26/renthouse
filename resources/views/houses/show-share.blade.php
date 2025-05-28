<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $house->name }} - Chi tiết nhà cho thuê</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f9fafb;
        }
        .btn-primary {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            background-color: #4f46e5;
            color: white;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-primary:hover {
            background-color: #4338ca;
        }
        .btn-secondary {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            background-color: #6b7280;
            color: white;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-secondary:hover {
            background-color: #4b5563;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Nội dung chính -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Phần hình ảnh -->
                <div class="p-6">
                    @if($images && $images->count() > 0)
                        <!-- Gallery ảnh -->
                        <div id="imageGallery" x-data="{ activeSlide: 0, totalSlides: {{ $images->count() }} }">
                            <!-- Slide chính -->
                            <div class="h-80 overflow-hidden rounded-lg shadow-md relative">
                                @foreach($images as $index => $image)
                                    <div x-show="activeSlide === {{ $index }}" 
                                         x-transition:enter="transition-opacity duration-500"
                                         x-transition:enter-start="opacity-0"
                                         x-transition:enter-end="opacity-100"
                                         class="w-full h-full" 
                                         style="{{ $index !== 0 ? 'display: none;' : '' }}">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $house->name }}" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                                
                                <!-- Nút điều hướng -->
                                <button @click="activeSlide = activeSlide === 0 ? totalSlides - 1 : activeSlide - 1" 
                                    class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white rounded-full p-2 hover:bg-opacity-75">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button @click="activeSlide = activeSlide === totalSlides - 1 ? 0 : activeSlide + 1" 
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white rounded-full p-2 hover:bg-opacity-75">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                            
                            <!-- Thumbnail -->
                            <div class="mt-4 grid grid-cols-6 gap-2">
                                @foreach($images as $index => $image)
                                    <div @click="activeSlide = {{ $index }}" 
                                        :class="{'ring-2 ring-indigo-500': activeSlide === {{ $index }}}"
                                        class="h-16 rounded-md overflow-hidden cursor-pointer">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $house->name }}" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @elseif ($house->image_path)
                        <div class="h-80 overflow-hidden rounded-lg shadow-md">
                            <img src="{{ asset('storage/' . $house->image_path) }}" alt="{{ $house->name }}" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="h-80 flex items-center justify-center bg-gray-100 rounded-lg shadow-md">
                            <i class="fas fa-home text-8xl text-gray-300"></i>
                        </div>
                    @endif
                    
                    <div class="mt-6">
                        <h2 class="text-xl font-bold mb-4">Dạng nhà</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['1K', '2K-2DK'] as $type)
                                <span class="px-4 py-2 text-sm rounded-md {{ $house->house_type === $type ? 'bg-blue-600 text-white font-bold' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $type }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Phần thông tin chi tiết -->
                <div class="p-6 border-l border-gray-200">
                    <div class="mb-6">
                        <span class="inline-block px-3 py-1 text-sm font-bold rounded-full 
                            {{ $house->status === 'available' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }} shadow">
                            {{ $house->status === 'available' ? 'Còn trống' : 'Đã thuê' }}
                        </span>
                    </div>
                    
                    <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $house->name }}</h1>
                    
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <h2 class="text-sm text-gray-600 mb-1">Giá thuê:</h2>
                            <p class="text-2xl font-bold text-green-600">{{ number_format($house->rent_price) }} <span class="text-base font-normal">yên/tháng</span></p>
                        </div>
                        
                        @if ($house->deposit_price)
                        <div>
                            <h2 class="text-sm text-gray-600 mb-1">Tiền đặt cọc:</h2>
                            <p class="text-xl font-bold text-gray-800">{{ number_format($house->deposit_price) }} <span class="text-sm font-normal">yên</span></p>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Chi phí ban đầu -->
                    @if ($house->initial_cost)
                    <div class="mb-6 p-4 bg-yellow-50 rounded-md border border-yellow-100">
                        <h2 class="text-md font-bold text-yellow-700 mb-2">Chi phí ban đầu:</h2>
                        <p class="text-xl font-bold text-gray-800 mb-2">{{ number_format($house->initial_cost) }} <span class="text-sm font-normal">yên</span></p>
                        
                        <div class="grid grid-cols-2 gap-4 mt-3">
                            @if (isset($house->cost_details['key_money']) && $house->cost_details['key_money'])
                            <div>
                                <h3 class="text-xs text-gray-500">Tiền lễ:</h3>
                                <p class="text-gray-700">{{ number_format($house->cost_details['key_money']) }} yên</p>
                            </div>
                            @endif
                            
                            @if (isset($house->cost_details['guarantee_fee']) && $house->cost_details['guarantee_fee'])
                            <div>
                                <h3 class="text-xs text-gray-500">Phí bảo lãnh:</h3>
                                <p class="text-gray-700">{{ number_format($house->cost_details['guarantee_fee']) }} yên</p>
                            </div>
                            @endif
                            
                            @if (isset($house->cost_details['insurance_fee']) && $house->cost_details['insurance_fee'])
                            <div>
                                <h3 class="text-xs text-gray-500">Phí bảo hiểm:</h3>
                                <p class="text-gray-700">{{ number_format($house->cost_details['insurance_fee']) }} yên</p>
                            </div>
                            @endif
                            
                            @if (isset($house->cost_details['document_fee']) && $house->cost_details['document_fee'])
                            <div>
                                <h3 class="text-xs text-gray-500">Phí hồ sơ:</h3>
                                <p class="text-gray-700">{{ number_format($house->cost_details['document_fee']) }} yên</p>
                            </div>
                            @endif
                        </div>
                        
                        @if (isset($house->cost_details['rent_included']) && $house->cost_details['rent_included'])
                        <p class="mt-3 text-sm text-gray-600">* Đã bao gồm tiền thuê tháng đầu</p>
                        @endif
                    </div>
                    @endif
                    
                    <div class="mb-6">
                        <h2 class="text-sm text-gray-600 mb-1">Địa chỉ:</h2>
                        <p class="text-gray-800 font-medium">{{ $house->address }}</p>
                        
                        @if ($house->location)
                        <div class="mt-3">
                            <h2 class="text-sm text-gray-600 mb-1">Khu vực:</h2>
                            <p class="text-gray-800">{{ $house->location }}</p>
                        </div>
                        @endif
                    </div>
                    
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <!-- Thông tin phòng -->
                        <div>
                            <h2 class="text-sm font-medium text-gray-700 mb-3">Thông tin phòng:</h2>
                            <ul class="space-y-2">
                                <li class="flex items-center">
                                    <span class="w-24 text-xs text-gray-500">Diện tích:</span>
                                    <span class="text-gray-800 font-medium">{{ $house->size }} m²</span>
                                </li>
                                
                                @if (isset($house->room_details['floor']))
                                <li class="flex items-center">
                                    <span class="w-24 text-xs text-gray-500">Tầng:</span>
                                    <span class="text-gray-800">{{ $house->room_details['floor'] }}</span>
                                </li>
                                @endif
                                
                                @if (isset($house->room_details['has_loft']) && $house->room_details['has_loft'])
                                <li class="flex items-center">
                                    <span class="w-24 text-xs text-gray-500">Gác lửng:</span>
                                    <span class="text-gray-800"><i class="fas fa-check text-green-500"></i> Có</span>
                                </li>
                                @endif
                            </ul>
                        </div>
                        
                        <!-- Thông tin di chuyển -->
                        <div>
                            <h2 class="text-sm font-medium text-gray-700 mb-3">Thông tin di chuyển:</h2>
                            <ul class="space-y-2">
                                @if (isset($house->room_details['nearest_station']) && $house->room_details['nearest_station'])
                                <li class="flex items-center">
                                    <span class="w-24 text-xs text-gray-500">Ga gần nhất:</span>
                                    <span class="text-gray-800">{{ $house->room_details['nearest_station'] }}</span>
                                </li>
                                @endif
                                
                                @if (isset($house->room_details['distance_to_station']) && $house->room_details['distance_to_station'])
                                <li class="flex items-center">
                                    <span class="w-24 text-xs text-gray-500">Khoảng cách:</span>
                                    <span class="text-gray-800">{{ $house->room_details['distance_to_station'] }} phút đi bộ</span>
                                </li>
                                @endif
                                
                                @if (isset($house->cost_details['parking_fee']) && $house->cost_details['parking_fee'])
                                <li class="flex items-center">
                                    <span class="w-24 text-xs text-gray-500">Phí đỗ xe:</span>
                                    <span class="text-gray-800">{{ number_format($house->cost_details['parking_fee']) }} yên/tháng</span>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Tiện ích -->
                    @if ($house->amenities && count(array_filter((array)$house->amenities)) > 0)
                    <div class="mb-6">
                        <h2 class="text-sm font-medium text-gray-700 mb-3">Tiện ích:</h2>
                        <div class="grid grid-cols-2 gap-2">
                            @if (isset($house->amenities['air_conditioner']) && $house->amenities['air_conditioner'])
                            <div class="flex items-center p-2 bg-gray-50 rounded-md">
                                <i class="fas fa-snowflake text-blue-500 mr-2"></i>
                                <span class="text-sm">Điều hòa</span>
                            </div>
                            @endif
                            
                            @if (isset($house->amenities['auto_lock']) && $house->amenities['auto_lock'])
                            <div class="flex items-center p-2 bg-gray-50 rounded-md">
                                <i class="fas fa-lock text-blue-500 mr-2"></i>
                                <span class="text-sm">Khóa tự động</span>
                            </div>
                            @endif
                            
                            @if (isset($house->amenities['bath_tub']) && $house->amenities['bath_tub'])
                            <div class="flex items-center p-2 bg-gray-50 rounded-md">
                                <i class="fas fa-bath text-blue-500 mr-2"></i>
                                <span class="text-sm">Bồn tắm</span>
                            </div>
                            @endif
                            
                            @if (isset($house->amenities['internet']) && $house->amenities['internet'])
                            <div class="flex items-center p-2 bg-gray-50 rounded-md">
                                <i class="fas fa-wifi text-blue-500 mr-2"></i>
                                <span class="text-sm">Internet</span>
                            </div>
                            @endif
                            
                            @if (isset($house->amenities['washing_machine']) && $house->amenities['washing_machine'])
                            <div class="flex items-center p-2 bg-gray-50 rounded-md">
                                <i class="fas fa-tshirt text-blue-500 mr-2"></i>
                                <span class="text-sm">Máy giặt</span>
                            </div>
                            @endif
                            
                            @if (isset($house->amenities['refrigerator']) && $house->amenities['refrigerator'])
                            <div class="flex items-center p-2 bg-gray-50 rounded-md">
                                <i class="fas fa-temperature-low text-blue-500 mr-2"></i>
                                <span class="text-sm">Tủ lạnh</span>
                            </div>
                            @endif
                            
                            @if (isset($house->amenities['tv']) && $house->amenities['tv'])
                            <div class="flex items-center p-2 bg-gray-50 rounded-md">
                                <i class="fas fa-tv text-blue-500 mr-2"></i>
                                <span class="text-sm">TV</span>
                            </div>
                            @endif
                            
                            @if (isset($house->amenities['kitchen']) && $house->amenities['kitchen'])
                            <div class="flex items-center p-2 bg-gray-50 rounded-md">
                                <i class="fas fa-utensils text-blue-500 mr-2"></i>
                                <span class="text-sm">Bếp</span>
                            </div>
                            @endif
                            
                            @if (isset($house->amenities['elevator']) && $house->amenities['elevator'])
                            <div class="flex items-center p-2 bg-gray-50 rounded-md">
                                <i class="fas fa-arrow-up text-blue-500 mr-2"></i>
                                <span class="text-sm">Thang máy</span>
                            </div>
                            @endif
                            
                            @if (isset($house->amenities['balcony']) && $house->amenities['balcony'])
                            <div class="flex items-center p-2 bg-gray-50 rounded-md">
                                <i class="fas fa-mountain text-blue-500 mr-2"></i>
                                <span class="text-sm">Ban công</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <!-- Mô tả -->
                    @if ($house->description)
                    <div class="mb-6">
                        <h2 class="text-sm font-medium text-gray-700 mb-3">Mô tả chi tiết:</h2>
                        <div class="p-4 bg-gray-50 rounded-md text-gray-700 whitespace-pre-line">
                            {{ $house->description }}
                        </div>
                    </div>
                    @endif
                    
                    <!-- Liên hệ -->
                    <div class="mt-8 bg-indigo-50 p-4 rounded-lg">
                        <h2 class="text-md font-medium text-indigo-700 mb-3">Thông tin liên hệ:</h2>
                        <div class="flex items-center mb-3">
                            <i class="fas fa-user-circle text-indigo-500 text-xl mr-3"></i>
                            <span class="text-gray-800 font-medium">{{ $house->user->name }}</span>
                        </div>
                        
                        @if ($house->user->company_name)
                        <div class="flex items-center mb-3">
                            <i class="fas fa-building text-indigo-500 text-xl mr-3"></i>
                            <span class="text-gray-800">{{ $house->user->company_name }}</span>
                        </div>
                        @endif
                        
                        @if ($house->user->phone_number)
                        <a href="tel:{{ $house->user->phone_number }}" class="block w-full mt-4 py-3 px-4 bg-indigo-600 text-white text-center rounded-md hover:bg-indigo-700 transition">
                            <i class="fas fa-phone-alt mr-2"></i> {{ $house->user->phone_number }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex justify-center mt-8">
            <div class="text-center">
                <p class="text-gray-600 text-sm">© {{ date('Y') }} WINHOMES - Nền tảng quản lý cho thuê nhà ở Nhật Bản</p>
            </div>
        </div>
    </div>
    
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Đã sao chép link vào clipboard!');
            });
        }
    </script>
</body>
</html>