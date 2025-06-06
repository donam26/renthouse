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
                  
                </div>
                
                <!-- Phần thông tin chi tiết -->
                <div class="p-6 border-l border-gray-200">
                    <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $house->name }}</h1>
                    
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <h2 class="text-sm text-gray-600 mb-1">Giá tiền:</h2>
                            <p class="text-2xl font-bold text-green-600">{{ number_format($house->rent_price) }} <span class="text-base font-normal">¥</span></p>
                        </div>
                        
                        <div>
                            <h2 class="text-sm text-gray-600 mb-1">Giá đầu vào:</h2>
                            <p class="text-xl font-bold text-gray-800">{{ number_format($house->input_price) }} <span class="text-sm font-normal">¥</span></p>
                        </div>
                    </div>

                    <!-- Mô tả chi tiết -->
                    @if ($house->description)
                    <div class="mb-6">
                        <h2 class="text-sm text-gray-600 mb-1">Mô tả chi tiết:</h2>
                        <div class="mt-2 p-4 bg-gray-50 rounded-lg text-gray-700">
                            {{ $house->description }}
                        </div>
                    </div>
                    @endif
                    
                    <!-- Thông tin ga tàu và loại nhà -->
                    <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-md font-bold text-gray-700 mb-3">Thông tin ga và loại nhà</h2>
                        <div class="space-y-3">
                            @if ($house->ga_chinh)
                            <div class="flex justify-between items-center p-2 border-b border-gray-200">
                                <div>
                                    <span class="text-xs text-gray-500">Ga chính:</span>
                                    <p class="text-sm font-medium">{{ $house->ga_chinh }}</p>
                                </div>
                                @if ($house->ga_chinh_house_type)
                                <span class="px-3 py-1 text-xs rounded-full {{ $house->ga_chinh_house_type == '1R-1K' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $house->ga_chinh_house_type }}
                                </span>
                                @endif
                            </div>
                            @endif
                            
                            @if ($house->ga_ben_canh)
                            <div class="flex justify-between items-center p-2 border-b border-gray-200">
                                <div>
                                    <span class="text-xs text-gray-500">Ga bên cạnh:</span>
                                    <p class="text-sm font-medium">{{ $house->ga_ben_canh }}</p>
                                </div>
                                @if ($house->ga_ben_canh_house_type)
                                <span class="px-3 py-1 text-xs rounded-full {{ $house->ga_ben_canh_house_type == '1R-1K' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $house->ga_ben_canh_house_type }}
                                </span>
                                @endif
                            </div>
                            @endif
                            
                            @if ($house->ga_di_tau_toi)
                            <div class="flex justify-between items-center p-2 border-b border-gray-200">
                                <div>
                                    <span class="text-xs text-gray-500">Ga đi tàu tới:</span>
                                    <p class="text-sm font-medium">{{ $house->ga_di_tau_toi }}</p>
                                </div>
                                @if ($house->ga_di_tau_toi_house_type)
                                <span class="px-3 py-1 text-xs rounded-full {{ $house->ga_di_tau_toi_house_type == '1R-1K' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $house->ga_di_tau_toi_house_type }}
                                </span>
                                @endif
                            </div>
                            @endif
                            
                            @if ($house->is_company)
                            <div class="flex justify-between items-center p-2">
                                <div>
                                    <span class="text-xs text-gray-500">Công ty:</span>
                                    <p class="text-sm font-medium">{{ $house->is_company ? 'Có' : 'Không' }}</p>
                                </div>
                                @if ($house->company_house_type)
                                <span class="px-3 py-1 text-xs rounded-full {{ $house->company_house_type == '1R-1K' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $house->company_house_type }}
                                </span>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                    
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
        
        <!-- Phần media của chủ nhà -->
        <div class="mt-8 bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 p-6">
            <h2 class="text-2xl font-bold text-indigo-700 mb-6 text-center">Thông tin bổ sung</h2>
            
            <!-- Phần Video -->
            @if($videos && $videos->count() > 0)
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">
                    <i class="fas fa-video mr-2 text-indigo-600"></i> Video giới thiệu
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
                                class="w-full h-48 object-cover hover:opacity-90 transition-opacity"
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
                                class="w-full h-32 object-cover hover:opacity-90 transition-opacity"
                            >
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
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