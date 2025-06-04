@extends('layouts.main')

@section('title', 'Chi tiết nhà cho thuê - ' . $house->name)

@section('header')
    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold">Chi tiết nhà cho thuê</h1>
        </div>
        @auth
            @if (Auth::id() === $house->user_id)
                <div class="flex space-x-2">
                    <a href="{{ route('houses.edit', $house) }}" class="btn-secondary inline-flex items-center self-start">
                        <i class="fas fa-edit mr-2"></i> Chỉnh sửa
                    </a>
                    <a href="{{ route('houses.by.username', $house->user->username) }}" class="btn-primary inline-flex items-center self-start">
                        <i class="fas fa-list mr-2"></i> Danh sách nhà
                    </a>
                </div>
            @endif
        @endauth
    </div>
@endsection

@section('content')
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
                        <p class="text-2xl font-bold text-green-600">{{ number_format($house->rent_price) }} <span class="text-base font-normal">yên/tháng</span></p>
                    </div>
                    
                    <div>
                        <h2 class="text-sm text-gray-600 mb-1">Giá đầu vào:</h2>
                        <p class="text-xl font-bold text-gray-800">{{ number_format($house->input_price) }} <span class="text-sm font-normal">yên</span></p>
                    </div>
                </div>
                
                <!-- Thông tin ga tàu và loại nhà -->
                <div class="mb-6 bg-gray-50 rounded-lg p-4">
                    <h2 class="text-sm font-medium text-gray-700 mb-3">Thông tin các ga và loại nhà:</h2>
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
                
                @if ($house->description)
                <div class="mb-6">
                    <h2 class="text-sm text-gray-600 mb-1">Mô tả chi tiết:</h2>
                    <div class="mt-2 p-4 bg-gray-50 rounded-lg text-gray-700">
                        {{ $house->description }}
                    </div>
                </div>
                @endif
                
                <div class="pt-6 mt-6 border-t border-gray-200">
                    <h2 class="text-sm text-gray-600 mb-2">Chủ sở hữu:</h2>
                    <div class="flex items-center">
                        <div class="h-12 w-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white flex-shrink-0 shadow-md">
                            <span class="text-lg font-bold">{{ substr($house->user->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-3">
                            <p class="font-bold text-gray-800">{{ $house->user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $house->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-6 flex justify-between">
        <a href="{{ url()->previous() }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại
        </a>
        
        @auth
            @if (Auth::id() === $house->user_id)
            <form action="{{ route('houses.destroy', $house) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-5 py-2.5 bg-red-600 text-white rounded-md shadow-md hover:bg-red-700 transition" 
                    onclick="return confirm('Bạn có chắc chắn muốn xóa nhà này không?')">
                    <i class="fas fa-trash mr-2"></i> Xóa nhà này
                </button>
            </form>
            @endif
        @endauth
    </div>
    
    @push('scripts')
    <script>
        // Hàm sao chép đường dẫn vào clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Đã copy link thành công!');
            }, function() {
                alert('Không thể copy link!');
            });
        }

        // Khởi tạo thư viện Alpine.js cho gallery hình ảnh nếu có
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
                        if (slides[index]) {
                            slides[index].style.display = 'block';
                        }
                        
                        // Cập nhật trạng thái thumbnails
                        thumbnails.forEach((thumb, i) => {
                            if (i === index) {
                                thumb.classList.add('ring-2', 'ring-indigo-500');
                            } else {
                                thumb.classList.remove('ring-2', 'ring-indigo-500');
                            }
                        });
                        
                        activeSlide = index;
                    }
                    
                    // Khởi tạo hiển thị slide đầu tiên
                    showSlide(0);
                    
                    // Xử lý nút trước
                    if (prevButton) {
                        prevButton.addEventListener('click', () => {
                            const newIndex = activeSlide === 0 ? totalSlides - 1 : activeSlide - 1;
                            showSlide(newIndex);
                        });
                    }
                    
                    // Xử lý nút sau
                    if (nextButton) {
                        nextButton.addEventListener('click', () => {
                            const newIndex = activeSlide === totalSlides - 1 ? 0 : activeSlide + 1;
                            showSlide(newIndex);
                        });
                    }
                    
                    // Xử lý click vào thumbnails
                    thumbnails.forEach((thumb, index) => {
                        thumb.addEventListener('click', () => {
                            showSlide(index);
                        });
                    });
                }
            }
        });
    </script>
    @endpush
@endsection 