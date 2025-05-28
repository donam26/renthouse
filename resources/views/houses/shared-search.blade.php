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
                    @if ($user->company_name)
                        <p class="text-indigo-100 mt-1">{{ $user->company_name }}</p>
                    @endif
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
                                
                                <!-- Badge hiển thị trạng thái -->
                                <div class="absolute top-3 left-3">
                                    <span class="px-3 py-1 text-xs font-bold rounded-full 
                                        {{ $house->status === 'available' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }} shadow">
                                        {{ $house->status === 'available' ? 'Còn trống' : 'Đã thuê' }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Phần thông tin (Chiếm 2/3 bên phải khi ở màn hình lớn) -->
                            <div class="md:col-span-2 p-5">
                                <!-- Thông tin cơ bản -->
                                <div class="grid grid-cols-3 gap-2 mb-4">
                                    <div class="col-span-3 md:col-span-1">
                                        @if (isset($house->room_details['distance_to_station']) && $house->room_details['distance_to_station'])
                                        <p class="text-sm text-gray-600">Khoảng cách:</p>
                                        <p class="font-medium text-gray-800">{{ $house->room_details['distance_to_station'] }} phút đi bộ</p>
                                        @endif
                                        
                                        <div class="mt-2 flex items-center">
                                            <span class="text-sm text-gray-600 mr-2">Đi bộ:</span>
                                            @if (isset($house->room_details['transportation']))
                                                @if ($house->room_details['transportation'] == 'Xe đạp')
                                                    <span class="flex items-center text-indigo-700">
                                                        <i class="fas fa-bicycle mr-1"></i> Xe đạp
                                                    </span>
                                                @elseif ($house->room_details['transportation'] == 'Tàu')
                                                    <span class="flex items-center text-indigo-700">
                                                        <i class="fas fa-train mr-1"></i> Tàu
                                                    </span>
                                                @else
                                                    <span class="flex items-center text-indigo-700">
                                                        <i class="fas fa-walking mr-1"></i> Đi bộ
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-span-3 md:col-span-1">
                                        <p class="text-sm text-gray-600">Giá thuê:</p>
                                        <p class="font-bold text-green-600 text-lg">{{ number_format($house->rent_price) }} <span class="text-sm font-normal">yên</span></p>
                                        
                                        @if ($house->deposit_price)
                                        <p class="text-sm text-gray-600 mt-1">Đặt cọc:</p>
                                        <p class="font-medium text-gray-800">{{ number_format($house->deposit_price) }} <span class="text-sm">yên</span></p>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Dạng nhà -->
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 mb-1">Dạng nhà:</p>
                                    <div class="flex space-x-2">
                                        @foreach(['1K', '2K-2DK'] as $type)
                                            <span class="px-3 py-1 text-xs rounded-md {{ $house->house_type === $type ? 'bg-blue-600 text-white font-bold' : 'bg-gray-100 text-gray-600' }}">
                                                {{ $type }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <!-- Địa chỉ -->
                                <div class="mb-4">
                                    <h3 class="font-bold text-lg text-gray-800">
                                        @if(isset($searchKeyword) && !empty($searchKeyword))
                                            {{ $searchKeyword }}
                                        @else
                                            {{ $house->name }}
                                        @endif
                                    </h3>
                                    <p class="text-gray-600 flex items-start mt-1">
                                        <i class="fas fa-map-marker-alt mt-1 mr-2 text-indigo-500"></i>
                                        <span>{{ $house->address }}</span>
                                    </p>
                                </div>
                                
                                <!-- Phần nút hành động -->
                                @if ($house->share_link)
                                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                                    <a href="{{ route('houses.share', $house->share_link) }}" class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                                        <span>Xem chi tiết</span>
                                        <i class="fas fa-arrow-right ml-1 text-sm"></i>
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