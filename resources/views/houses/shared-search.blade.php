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
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Bất động sản của {{ $user->name }}</h1>
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
                            <div class="h-64 md:h-full relative overflow-hidden">
                                @if ($house->images && $house->images->where('is_primary', true)->first())
                                    <img src="{{ asset('storage/' . $house->images->where('is_primary', true)->first()->image_path) }}" 
                                        alt="{{ $house->name }}" class="w-full h-full object-cover">
                                @elseif ($house->image_path)
                                    <img src="{{ asset('storage/' . $house->image_path) }}" 
                                        alt="{{ $house->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full bg-gray-100">
                                        <i class="fas fa-home text-6xl text-gray-300"></i>
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
                                            @endphp
                                            {{ $distance }} phút
                                            @if (request('transportation') == 'walking' || $house->transportation == 'Đi bộ')
                                                <i class="fas fa-walking ml-1 mr-1 text-indigo-700"></i> đi bộ
                                            @elseif (request('transportation') == 'bicycle' || $house->transportation == 'Xe đạp')
                                                <i class="fas fa-bicycle ml-1 mr-1 text-indigo-700"></i> bằng xe đạp
                                            @elseif (request('transportation') == 'train' || $house->transportation == 'Tàu')
                                                <i class="fas fa-train ml-1 mr-1 text-indigo-700"></i> bằng tàu
                                            @else
                                                <i class="fas fa-walking ml-1 mr-1 text-indigo-700"></i> đi bộ
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <div class="col-span-3 md:col-span-1">
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
                                
                                <!-- Thông tin ga tàu -->
                                @if (request('ga_chinh') || request('ga_ben_canh') || request('ga_di_tau_toi') || request('is_company') == '1' || request('house_type') || request('transportation') || request('distance'))
                                <div class="mb-4 bg-gray-50 p-3 rounded-md">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Thông tin áp dụng:</p>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        @if (request('ga_chinh'))
                                        <div>
                                            <p class="text-xs text-gray-500">Ga chính:</p>
                                            <p class="text-sm font-medium text-indigo-700">{{ request('ga_chinh') }}</p>
                                        </div>
                                        @endif
                                        
                                        @if (request('ga_ben_canh'))
                                        <div>
                                            <p class="text-xs text-gray-500">Ga bên cạnh:</p>
                                            <p class="text-sm font-medium text-indigo-700">{{ request('ga_ben_canh') }}</p>
                                        </div>
                                        @endif
                                        
                                        @if (request('ga_di_tau_toi'))
                                        <div>
                                            <p class="text-xs text-gray-500">Ga đi tàu tới:</p>
                                            <p class="text-sm font-medium text-indigo-700">{{ request('ga_di_tau_toi') }}</p>
                                        </div>
                                        @endif
                                        
                                        @if (request('distance'))
                                        <div>
                                            <p class="text-xs text-gray-500">Khoảng cách:</p>
                                            <p class="text-sm font-medium text-indigo-700">
                                                @php
                                                    $displayDistance = isset($house->adjusted_distance) ? $house->adjusted_distance : request('distance');
                                                    $displayDistance = is_numeric($displayDistance) ? round($displayDistance) : $displayDistance;
                                                @endphp
                                                {{ $displayDistance }} phút đi bộ
                                            </p>
                                        </div>
                                        @endif
                                        
                                        @if (request('house_type'))
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
                                        
                                        @if (request('is_company') == '1')
                                        <div>
                                            <p class="text-xs text-gray-500">Địa điểm:</p>
                                            <p class="text-sm font-medium text-indigo-700">Công ty</p>
                                        </div>
                                        @endif
                                    </div>
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
                                    <a href="{{ route('houses.share', $house->share_link) }}" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-medium flex items-center shadow-sm transition-colors duration-200">
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