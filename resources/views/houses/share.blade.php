<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết nhà cho thuê - {{ $house->name }}</title>
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
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-indigo-600 py-6 px-6 rounded-lg shadow-md mb-8">
            <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Chi tiết nhà cho thuê</h1>
                </div>
                <a href="{{ route('login') }}" class="btn-primary inline-flex items-center self-start">
                    <i class="fas fa-sign-in-alt mr-2"></i> Đăng nhập
                </a>
            </div>
        </div>

        <!-- Chi tiết nhà -->
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
                            @foreach(['1r-1K', '2K-2DK'] as $type)
                                <span class="px-4 py-2 text-sm rounded-md {{ $house->house_type === $type ? 'bg-blue-600 text-white font-bold' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $type }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Phần thông tin chi tiết -->
                <div class="p-6 border-l border-gray-200">
                    <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $house->name }}</h1>
                    
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <h2 class="text-sm text-gray-600 mb-1">Giá thuê:</h2>
                            <p class="text-2xl font-bold text-green-600">{{ number_format($house->rent_price) }} <span class="text-base font-normal">¥</span></p>
                        </div>
                        
                        <div>
                            <h2 class="text-sm text-gray-600 mb-1">Giá đầu vào:</h2>
                            <p class="text-xl font-bold text-gray-800">{{ number_format($house->input_price) }} <span class="text-sm font-normal">¥</span></p>
                        </div>
                    </div>
                    
                    <!-- Thông tin ga tàu -->
                    @if ($house->ga_chinh || $house->ga_ben_canh || $house->ga_di_tau_toi || $house->is_company)
                    <div class="mb-6 bg-gray-50 p-4 rounded-md">
                        <h2 class="text-md font-bold mb-3">Thông tin áp dụng:</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if ($house->ga_chinh)
                            <div>
                                <p class="text-xs text-gray-500">Ga chính:</p>
                                <p class="text-sm font-medium text-indigo-700">{{ $house->ga_chinh }}</p>
                            </div>
                            @endif
                            
                            @if ($house->ga_ben_canh)
                            <div>
                                <p class="text-xs text-gray-500">Ga bên cạnh:</p>
                                <p class="text-sm font-medium text-indigo-700">{{ $house->ga_ben_canh }}</p>
                            </div>
                            @endif
                            
                            @if ($house->ga_di_tau_toi)
                            <div>
                                <p class="text-xs text-gray-500">Ga đi tàu tới:</p>
                                <p class="text-sm font-medium text-indigo-700">{{ $house->ga_di_tau_toi }}</p>
                            </div>
                            @endif
                            
                            @if ($house->distance_to_station)
                            <div>
                                <p class="text-xs text-gray-500">Khoảng cách:</p>
                                <p class="text-sm font-medium text-indigo-700">{{ $house->distance_to_station }} phút đi bộ</p>
                            </div>
                            @endif
                            
                            @if ($house->is_company)
                            <div>
                                <p class="text-xs text-gray-500">Địa điểm:</p>
                                <p class="text-sm font-medium text-indigo-700">Công ty</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <div class="mb-6">
                        <h2 class="text-sm text-gray-600 mb-1">Phương tiện đi lại:</h2>
                        <p class="text-gray-800 font-medium">
                            @if ($house->transportation == 'Đi bộ')
                                <span class="flex items-center text-indigo-700">
                                    <i class="fas fa-walking mr-1"></i> Đi bộ
                                </span>
                            @elseif ($house->transportation == 'Xe đạp')
                                <span class="flex items-center text-indigo-700">
                                    <i class="fas fa-bicycle mr-1"></i> Xe đạp
                                </span>
                            @elseif ($house->transportation == 'Tàu')
                                <span class="flex items-center text-indigo-700">
                                    <i class="fas fa-train mr-1"></i> Tàu
                                </span>
                            @else
                                <span class="flex items-center text-indigo-700">
                                    <i class="fas fa-walking mr-1"></i> Đi bộ
                                </span>
                            @endif
                        </p>
                    </div>
                    
                    <div class="pt-6 mt-6 border-t border-gray-200">
                        <h2 class="text-sm text-gray-600 mb-2">Chủ sở hữu:</h2>
                        <div class="flex items-center">
                            <div class="h-12 w-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white flex-shrink-0 shadow-md">
                                <span class="text-lg font-bold">{{ substr($house->user->name, 0, 1) }}</span>
                            </div>
                            <div class="ml-3">
                                <p class="font-bold text-gray-800">{{ $house->user->name }}</p>
                                @if ($house->user->phone_number)
                                    <p class="text-sm text-gray-600">{{ $house->user->phone_number }}</p>
                                @endif
                                <p class="text-sm text-gray-600">{{ $house->user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-8 text-center">
            <p class="text-gray-600 text-sm">© {{ date('Y') }} WINHOMES - Nền tảng quản lý cho thuê nhà ở Nhật Bản</p>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Kiểm tra xem Alpine.js đã sẵn sàng chưa
            if (typeof Alpine === 'undefined') {
                console.warn('Alpine.js chưa được load, đang sử dụng JavaScript thuần');
                
                // Fallback gallery với JavaScript thuần
                const gallery = document.getElementById('imageGallery');
                if (gallery) {
                    let activeSlide = 0;
                    const slides = gallery.querySelectorAll('.h-80 > div');
                    const totalSlides = slides.length;
                    const thumbnails = gallery.querySelectorAll('.mt-4 > div');
                    const prevButton = gallery.querySelector('.h-80 button:first-child');
                    const nextButton = gallery.querySelector('.h-80 button:last-child');
                    
                    function showSlide(index) {
                        // Ẩn tất cả các slide
                        slides.forEach(slide => slide.style.display = 'none');
                        
                        // Hiển thị slide được chọn
                        slides[index].style.display = 'block';
                        
                        // Cập nhật active thumbnail
                        thumbnails.forEach(thumb => thumb.classList.remove('ring-2', 'ring-indigo-500'));
                        thumbnails[index].classList.add('ring-2', 'ring-indigo-500');
                        
                        // Cập nhật active slide
                        activeSlide = index;
                    }
                    
                    // Thiết lập sự kiện cho nút prev
                    if (prevButton) {
                        prevButton.addEventListener('click', function() {
                            showSlide(activeSlide === 0 ? totalSlides - 1 : activeSlide - 1);
                        });
                    }
                    
                    // Thiết lập sự kiện cho nút next
                    if (nextButton) {
                        nextButton.addEventListener('click', function() {
                            showSlide(activeSlide === totalSlides - 1 ? 0 : activeSlide + 1);
                        });
                    }
                    
                    // Thiết lập sự kiện cho thumbnails
                    thumbnails.forEach((thumb, index) => {
                        thumb.addEventListener('click', function() {
                            showSlide(index);
                        });
                    });
                }
            }
        });
    </script>
</body>
</html> 