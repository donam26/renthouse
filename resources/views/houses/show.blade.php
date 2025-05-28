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
                
                @if ($house->share_link)
                <div class="mt-6 p-4 bg-indigo-50 rounded-lg">
                    <h2 class="text-md font-bold text-indigo-700 mb-2">Chia sẻ nhà này</h2>
                    <div class="flex space-x-2">
                        <a href="{{ route('houses.share', $house->share_link) }}" target="_blank" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition flex-1 text-center">
                            <i class="fas fa-external-link-alt mr-2"></i> Mở link
                        </a>
                        <button 
                            onclick="copyToClipboard('{{ route('houses.share', $house->share_link) }}')" 
                            class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition flex-1">
                            <i class="fas fa-copy mr-2"></i> Copy link
                        </button>
                    </div>
                </div>
                @endif
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
                        
                        @if (isset($house->amenities['refrigerator']) && $house->amenities['refrigerator'])
                        <div class="flex items-center p-2 bg-gray-50 rounded-md">
                            <i class="fas fa-cube text-blue-500 mr-2"></i>
                            <span class="text-sm">Tủ lạnh</span>
                        </div>
                        @endif
                        
                        @if (isset($house->amenities['washing_machine']) && $house->amenities['washing_machine'])
                        <div class="flex items-center p-2 bg-gray-50 rounded-md">
                            <i class="fas fa-tshirt text-blue-500 mr-2"></i>
                            <span class="text-sm">Máy giặt</span>
                        </div>
                        @endif
                        
                        @if (isset($house->amenities['internet']) && $house->amenities['internet'])
                        <div class="flex items-center p-2 bg-gray-50 rounded-md">
                            <i class="fas fa-wifi text-blue-500 mr-2"></i>
                            <span class="text-sm">Internet</span>
                        </div>
                        @endif
                        
                        @if (isset($house->amenities['furniture']) && $house->amenities['furniture'])
                        <div class="flex items-center p-2 bg-gray-50 rounded-md">
                            <i class="fas fa-couch text-blue-500 mr-2"></i>
                            <span class="text-sm">Nội thất</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                
                @if ($house->description)
                <div class="mb-6">
                    <h2 class="text-sm text-gray-600 mb-1">Mô tả:</h2>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <p class="text-gray-800 whitespace-pre-line">{{ $house->description }}</p>
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