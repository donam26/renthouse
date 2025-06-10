<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm nhà cho thuê của {{ $user->name }}</title>
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
        .input-field {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
            outline: none;
            transition: all 0.2s;
        }
        .input-field:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 1px #4f46e5;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-indigo-600 py-6 px-6 rounded-lg shadow-md mb-8">
            <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
                <div class="flex items-center">
                        <!-- Logo -->
                        <a href="{{ Auth::check() ? '/' . Auth::user()->username : '/' }}" class="flex-shrink-0 flex items-center">
                        <span class="text-2xl font-bold text-white">WIN<span class="text-gray-800">HOMES</span></span>
                        @auth
                            <span class="ml-2 text-xl uppercase text-white hidden sm:inline-block">{{ Auth::user()->name }}</span>
                            @endauth
                        </a>
                    </div>
            </div>
        </div>


        <!-- Danh sách nhà -->
        @if ($houses->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/6598/6598519.png" alt="Không có nhà" class="w-32 h-32 mx-auto mb-6 opacity-50">
                <h3 class="text-xl font-bold text-gray-700">Không tìm thấy nhà cho thuê nào</h3>
                <p class="text-gray-500 my-4">Không có nhà cho thuê nào phù hợp với tiêu chí tìm kiếm của bạn.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($houses as $house)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                        <div class="grid grid-cols-1 md:grid-cols-3">
                            <!-- Phần ảnh nhà (Chiếm 1/3 bên trái khi ở màn hình lớn) -->
                            <div class="relative">
                                <!-- Phần ảnh chính -->
                                <div class="h-48 md:h-56 md:max-h-64 relative overflow-hidden rounded-t-lg">
                                    @if ($house->images && $house->images->where('is_primary', true)->first())
                                        <img src="{{ asset('storage/' . $house->images->where('is_primary', true)->first()->image_path) }}" 
                                            alt="{{ $house->name }}" class="w-full h-full object-contain md:object-cover object-center cursor-pointer"
                                            data-fancybox="house-{{ $house->id }}" data-caption="Ảnh chính">
                                    @elseif ($house->image_path)
                                        <img src="{{ asset('storage/' . $house->image_path) }}" 
                                            alt="{{ $house->name }}" class="w-full h-full object-contain md:object-cover object-center cursor-pointer"
                                            data-fancybox="house-{{ $house->id }}" data-caption="Ảnh chính">
                                    @else
                                        <div class="flex items-center justify-center h-full bg-gray-100">
                                            <i class="fas fa-home text-6xl text-gray-300"></i>
                                        </div>
                                    @endif
                                    
                                    @if($house->images && $house->images->count() > 0)
                                    <div class="absolute top-2 right-2 bg-black bg-opacity-60 text-white rounded-full h-8 w-8 flex items-center justify-center">
                                        <span class="text-xs">1/{{ $house->images->count() + 1 }}</span>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Phần ảnh phụ -->
                                @if($house->images && $house->images->count() > 0)
                                <div class="flex overflow-x-auto gap-1 py-1 bg-gray-100 scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-100 rounded-b-lg">
                                    <!-- Ảnh chính -->
                                    <div class="flex-shrink-0 w-16 h-16">
                                        @if ($house->images->where('is_primary', true)->first())
                                            <img src="{{ asset('storage/' . $house->images->where('is_primary', true)->first()->image_path) }}" 
                                                alt="Ảnh chính" 
                                                class="w-full h-full object-cover object-center border-2 border-indigo-500 rounded cursor-pointer" 
                                                data-fancybox="house-{{ $house->id }}"
                                                data-caption="Ảnh chính">
                                        @elseif ($house->image_path)
                                            <img src="{{ asset('storage/' . $house->image_path) }}" 
                                                alt="Ảnh chính" 
                                                class="w-full h-full object-cover object-center border-2 border-indigo-500 rounded cursor-pointer" 
                                                data-fancybox="house-{{ $house->id }}"
                                                data-caption="Ảnh chính">
                                        @endif
                                    </div>
                                    
                                    <!-- Các ảnh phụ -->
                                    @foreach($house->images->where('is_primary', false) as $image)
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
                                <!-- Thông tin cơ bản -->
                                <div class="grid grid-cols-3 gap-2 mb-4">
                                    <div class="col-span-3 md:col-span-1">
                                        <!-- Thời gian đi lại -->
                                        <p class="text-sm text-gray-600">Thời gian đi lại:</p>
                                        <p class="font-medium text-gray-800">
                                            @php
                                                $distance = isset($house->adjusted_distance) ? $house->adjusted_distance : ($house->distance ?: '12');
                                                $distance = is_numeric($distance) ? round($distance) : $distance;
                                                
                                                // Xác định phương tiện từ request hoặc dữ liệu của house
                                                $transportation = request('transportation');
                                                if ($transportation == 'walking') {
                                                    $transportIcon = 'fa-walking';
                                                    $transportText = 'đi bộ';
                                                } elseif ($transportation == 'bicycle') {
                                                    $transportIcon = 'fa-bicycle';
                                                    $transportText = 'bằng xe đạp';
                                                } elseif ($transportation == 'train') {
                                                    $transportIcon = 'fa-train';
                                                    $transportText = 'bằng tàu';
                                                } elseif ($house->transportation == 'Xe đạp') {
                                                    $transportIcon = 'fa-bicycle';
                                                    $transportText = 'bằng xe đạp';
                                                } elseif ($house->transportation == 'Tàu') {
                                                    $transportIcon = 'fa-train';
                                                    $transportText = 'bằng tàu';
                                                } else {
                                                    $transportIcon = 'fa-walking';
                                                    $transportText = 'đi bộ';
                                                }
                                            @endphp
                                            {{ $distance }} phút
                                            <i class="fas {{ $transportIcon }} ml-1 mr-1 text-indigo-700"></i> {{ $transportText }}
                                        </p>
                                    </div>
                                    
                                    <div class="col-span-3 md:col-span-1">
                                        <p class="text-sm text-gray-600">Giá tiền:</p>
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
                                
                                <!-- Thông tin được apply -->
                                @if (request('apply_location'))
                                <div class="mb-4 bg-gray-50 p-3 rounded-md">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Thông tin được apply:</p>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        @if (request('apply_location') == 'ga_chinh' && request('ga_chinh_value'))
                                        <div>
                                            <p class="text-xs text-gray-500">Ga chính (Applied):</p>
                                            <p class="text-sm font-medium text-indigo-700 flex items-center">
                                                <i class="fas fa-train mr-1"></i>
                                                {{ request('ga_chinh_value') }}
                                            </p>
                                        </div>
                                        @elseif (request('apply_location') == 'ga_ben_canh' && request('ga_ben_canh_value'))
                                        <div>
                                            <p class="text-xs text-gray-500">Ga bên cạnh (Applied):</p>
                                            <p class="text-sm font-medium text-indigo-700 flex items-center">
                                                <i class="fas fa-subway mr-1"></i>
                                                {{ request('ga_ben_canh_value') }}
                                            </p>
                                        </div>
                                        @elseif (request('apply_location') == 'ga_di_tau_toi' && request('ga_di_tau_toi_value'))
                                        <div>
                                            <p class="text-xs text-gray-500">Ga tàu tới (Applied):</p>
                                            <p class="text-sm font-medium text-indigo-700 flex items-center">
                                                <i class="fas fa-route mr-1"></i>
                                                {{ request('ga_di_tau_toi_value') }}
                                            </p>
                                        </div>
                                        @elseif (request('apply_location') == 'company')
                                        <div>
                                            <p class="text-xs text-gray-500">Địa điểm (Applied):</p>
                                            <p class="text-sm font-medium text-indigo-700 flex items-center">
                                                <i class="fas fa-building mr-1"></i>
                                                Công ty
                                            </p>
                                        </div>
                                        @endif
                                        
                                        @if (request('distance'))
                                        <div>
                                            <p class="text-xs text-gray-500">Khoảng cách (Applied):</p>
                                            <p class="text-sm font-medium text-indigo-700 flex items-center">
                                                <i class="fas fa-clock mr-1"></i>
                                                @php
                                                    $displayDistance = isset($house->adjusted_distance) ? $house->adjusted_distance : request('distance');
                                                    $displayDistance = is_numeric($displayDistance) ? round($displayDistance) : $displayDistance;
                                                    
                                                    $transportationText = 'đi bộ';
                                                    if (request('transportation') == 'bicycle') {
                                                        $transportationText = 'bằng xe đạp';
                                                    } elseif (request('transportation') == 'train') {
                                                        $transportationText = 'bằng tàu';
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
                                    </div>
                                </div>
                                @else
                                <div class="mb-4 bg-yellow-50 border border-yellow-200 rounded-md p-3">
                                    <p class="text-sm text-yellow-700 flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        Chưa có thông tin apply nào được thiết lập.
                                    </p>
                                </div>
                                @endif
                                
                                <!-- Dạng nhà -->
                                @if (!request('house_type'))
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 mb-1">Dạng nhà:</p>
                                    <div class="flex space-x-2">
                                        @foreach(['1R-1K', '2K-2DK'] as $type)
                                            <span class="px-3 py-1 text-xs rounded-md {{ $house->default_house_type === $type ? 'bg-blue-600 text-white font-bold' : 'bg-gray-100 text-gray-600' }}">
                                                {{ $type }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            
                                
                                <!-- Phần nút hành động -->
                                @if ($house->share_link)
                                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                                    @php
                                        // Tạo URL với virtual data parameters
                                        $shareUrl = route('houses.share', $house->share_link);
                                        $params = [];
                                        
                                        if (request('apply_location')) {
                                            $params['apply_location'] = request('apply_location');
                                        }
                                        if (request('ga_chinh_value')) {
                                            $params['ga_chinh_value'] = request('ga_chinh_value');
                                        }
                                        if (request('ga_ben_canh_value')) {
                                            $params['ga_ben_canh_value'] = request('ga_ben_canh_value');
                                        }
                                        if (request('ga_di_tau_toi_value')) {
                                            $params['ga_di_tau_toi_value'] = request('ga_di_tau_toi_value');
                                        }
                                        if (request('min_price')) {
                                            $params['min_price'] = request('min_price');
                                        }
                                        if (request('input_price')) {
                                            $params['input_price'] = request('input_price');
                                        }
                                        if (request('distance')) {
                                            $params['distance'] = request('distance');
                                        }
                                        if (request('transportation')) {
                                            $params['transportation'] = request('transportation');
                                        }
                                        
                                        if (!empty($params)) {
                                            $shareUrl .= '?' . http_build_query($params);
                                        }
                                    @endphp
                                    <a href="{{ $shareUrl }}" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-medium flex items-center shadow-sm transition-colors duration-200">
                                        <span>Xem chi tiết</span>
                                        <i class="fas fa-arrow-right ml-2 text-sm"></i>
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        
        <!-- Phần media của chủ nhà -->
        @if(($videos && $videos->count() > 0) || ($licenses && $licenses->count() > 0) || ($interactions && $interactions->count() > 0))
        <div class="mt-8 bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 p-6">
            <!-- Phần Video -->
            @if($videos && $videos->count() > 0)
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">
                    <i class="fas fa-video mr-2 text-indigo-600"></i> Giới thiệu
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($videos as $video)
                    <div class="bg-gray-50 rounded-lg overflow-hidden shadow-md">
                        <div class="aspect-video">
                            <video 
                                class="w-full h-full object-cover" 
                                controls 
                                preload="none" 
                                poster="{{ asset('storage/' . str_replace('.mp4', '.jpg', $video->file_path)) }}"
                            >
                                <source src="{{ asset('storage/' . $video->file_path) }}" type="video/mp4">
                                Trình duyệt của bạn không hỗ trợ tag video.
                            </video>
                        </div>
                        @if($video->title)
                        <div class="p-3 bg-white">
                            <h4 class="font-medium text-gray-800">{{ $video->title }}</h4>
                            @if($video->description)
                            <p class="text-sm text-gray-600 mt-1">{{ $video->description }}</p>
                            @endif
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Phần Giấy phép -->
            @if($licenses && $licenses->count() > 0)
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">
                    <i class="fas fa-certificate mr-2 text-indigo-600"></i> Giấy phép & Chứng chỉ
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($licenses as $license)
                    <div class="bg-gray-50 rounded-lg overflow-hidden shadow-md">
                        <a href="{{ asset('storage/' . $license->file_path) }}" 
                           class="block" 
                           target="_blank" 
                           data-fancybox="licenses"
                           data-caption="{{ $license->title }}">
                            <img 
                                src="{{ asset('storage/' . $license->file_path) }}" 
                                alt="{{ $license->title }}" 
                                class="w-full h-48 object-cover object-center hover:opacity-90 transition-opacity"
                            >
                        </a>
                        @if($license->title)
                        <div class="p-3 bg-white">
                            <h4 class="font-medium text-gray-800 text-sm">{{ $license->title }}</h4>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Phần Hình ảnh tương tác với khách -->
            @if($interactions && $interactions->count() > 0)
            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">
                    <i class="fas fa-users mr-2 text-indigo-600"></i> Tương tác với khách hàng
                </h3>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                    @foreach($interactions as $interaction)
                    <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <a href="{{ asset('storage/' . $interaction->file_path) }}" 
                           class="block" 
                           target="_blank" 
                           data-fancybox="interactions"
                           data-caption="{{ $interaction->title }}">
                            <img 
                                src="{{ asset('storage/' . $interaction->file_path) }}" 
                                alt="{{ $interaction->title }}" 
                                class="w-full h-32 object-cover object-center hover:opacity-90 transition-opacity"
                            >
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif
        
        <div class="flex justify-center mt-8">
            <div class="text-center">
                <p class="text-gray-600 text-sm">© {{ date('Y') }} WINHOMES - Nền tảng quản lý cho thuê nhà ở Nhật Bản</p>
            </div>
        </div>
    </div>
    
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                window.toast.success('Đã sao chép link vào clipboard!', 'Copy thành công');
            }).catch(() => {
                window.toast.error('Không thể sao chép link!', 'Lỗi copy');
            });
        }
    </script>
    
    <!-- Fancybox JS cho popup ảnh lớn -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Khởi tạo Fancybox nếu có
            if (typeof Fancybox !== 'undefined') {
                Fancybox.bind("[data-fancybox]", {
                    // Cấu hình Fancybox
                });
            }
        });
    </script>
</body>
</html> 