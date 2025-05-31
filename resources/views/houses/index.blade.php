@extends('layouts.main')

@section('title', 'Nhà cho thuê của tôi')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-2xl md:text-3xl font-bold">Danh sách nhà cho thuê của tôi</h1>
        <a href="{{ route('houses.create') }}" class="btn-primary inline-flex items-center">
            <i class="fas fa-plus-circle mr-2"></i> Thêm nhà mới
        </a>
    </div>
@endsection

@section('content')
    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg p-4 shadow-sm flex items-center border-l-4 border-indigo-500">
            <div class="mr-4 bg-indigo-100 rounded-full p-3">
                <i class="fas fa-home text-indigo-500 text-xl"></i>
            </div>
            <div>
                <h3 class="text-sm text-gray-500">Tổng số nhà</h3>
                <p class="text-2xl font-bold">{{ $houses->count() }}</p>
            </div>
        </div>
      
    </div>
    
    <!-- Tìm kiếm và lọc -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <i class="fas fa-filter text-indigo-600 mr-2"></i>
                <h2 class="text-lg font-medium text-gray-800">Giá trị apply</h2>
            </div>
            
            <button 
                onclick="shareSearchResults()" 
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition flex items-center">
                <i class="fas fa-share-alt mr-2"></i> Share Link
            </button>
        </div>
        
        <form action="{{ route('houses.index') }}" method="GET">
            <!-- Tìm kiếm tên, địa chỉ -->
            <div class="mb-6">
                <label for="search" class="block mb-2 text-sm font-medium text-gray-700">Tìm kiếm</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Tìm theo tên, địa chỉ...">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Khoảng cách -->
                <div>
                    <label for="distance" class="block mb-2 text-sm font-medium text-gray-700">Khoảng cách</label>
                    <div class="relative">
                        <input type="text" name="distance" id="distance" 
                            value="{{ request('distance') }}"
                            class="block w-full pr-12 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Nhập khoảng cách">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500 text-sm">
                            vđ 5Phút
                        </div>
                    </div>
                </div>
                
                <!-- Giá thuê từ -->
                <div>
                    <label for="min_price" class="block mb-2 text-sm font-medium text-gray-700">Giá thuê (từ điển)</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">¥</span>
                        <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" 
                            class="block w-full rounded-none sm:text-sm border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="3000">
                    </div>
                </div>
                
                <!-- Giá thuê đến -->
                <div>
                    <label for="max_price" class="block mb-2 text-sm font-medium text-gray-700">Đến</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">¥</span>
                        <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" 
                            class="block w-full rounded-none rounded-r-md sm:text-sm border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="10000">
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Dạng nhà -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Dạng nhà</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['1K', '2K-2DK'] as $type)
                            <label class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm cursor-pointer hover:bg-gray-50 {{ request('house_type') == $type ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'text-gray-700' }}">
                                <input type="radio" name="house_type" value="{{ $type }}" class="hidden" {{ request('house_type') == $type ? 'checked' : '' }}>
                                {{ $type }}
                            </label>
                        @endforeach
                    </div>
                </div>
           
            </div>
            
            <div class="mb-6">
                <!-- Phương tiện đi lại -->
                <div>
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
            </div>
            
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <label class="block text-sm font-medium text-gray-700 mr-3">Sắp xếp theo:</label>
                    <select id="sort_by" name="sort_by" class="py-1 px-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="oldest" {{ request('sort_by') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                        <option value="price_low" {{ request('sort_by') == 'price_low' ? 'selected' : '' }}>Giá thấp đến cao</option>
                        <option value="price_high" {{ request('sort_by') == 'price_high' ? 'selected' : '' }}>Giá cao đến thấp</option>
                    </select>
                </div>
                
                <div class="flex space-x-3">
                    <a href="{{ route('houses.index') }}" class="inline-flex items-center py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-undo mr-2"></i> Đặt lại
                    </a>
                    <button type="submit" class="flex items-center justify-center py-2 px-5 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        <i class="fas fa-search mr-2"></i> Apply
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    @if ($houses->isEmpty())
        <div class="card p-12 text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/6598/6598519.png" alt="Không có nhà" class="w-32 h-32 mx-auto mb-6 opacity-50">
            <h3 class="text-xl font-bold text-gray-700">Bạn chưa có nhà cho thuê nào</h3>
            <p class="text-gray-500 my-4">Bắt đầu thêm các nhà cho thuê của bạn để quản lý dễ dàng hơn.</p>
            <a href="{{ route('houses.create') }}" class="btn-primary inline-flex items-center mt-2">
                <i class="fas fa-plus-circle mr-2"></i> Thêm nhà mới ngay
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($houses as $house)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 group">
                    <!-- Phần ảnh -->
                    <div class="relative h-56 overflow-hidden">
                        @if ($house->images && $house->images->where('is_primary', true)->first())
                            <img src="{{ asset('storage/' . $house->images->where('is_primary', true)->first()->image_path) }}" 
                                 alt="{{ $house->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @elseif ($house->image_path)
                            <img src="{{ asset('storage/' . $house->image_path) }}" 
                                 alt="{{ $house->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="flex items-center justify-center h-full bg-gray-100 group-hover:bg-gray-200 transition-colors">
                                <i class="fas fa-home text-6xl text-gray-300"></i>
                            </div>
                        @endif
                        
                        <!-- Thẻ trạng thái và loại nhà -->
                        <div class="absolute top-3 right-3 flex flex-col space-y-2">
                            
                            @if ($house->house_type)
                                <span class="px-3 py-1 text-xs font-bold bg-blue-500 text-white rounded-full shadow-md">
                                    {{ $house->house_type }}
                                </span>
                            @endif
                        </div>
                        
                        <!-- Giá thuê -->
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent text-white p-3">
                            <p class="text-lg font-bold">{{ number_format($house->rent_price) }} <span class="text-sm font-normal">¥/tháng</span></p>
                            @if ($house->size)
                                <p class="text-sm">{{ $house->size }} m² · {{ number_format($house->rent_price / $house->size) }}¥/m²</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Phần thông tin -->
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-800 mb-2 truncate group-hover:text-indigo-600 transition-colors">
                            @if(isset($searchKeyword) && !empty($searchKeyword))
                                {{ $searchKeyword }}
                            @else
                                {{ $house->name }}
                            @endif
                        </h3>
                        
                        <!-- Phần nút thao tác -->
                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <a href="{{ route('houses.show', $house) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition">
                                <span>Chi tiết</span>
                                <i class="fas fa-chevron-right ml-1 text-xs"></i>
                            </a>
                            
                            <div class="flex space-x-2">
                                <a href="{{ route('houses.edit', $house) }}" class="p-2 text-blue-500 hover:bg-blue-50 rounded-full transition tooltip" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="{{ route('houses.destroy', $house) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-full transition tooltip" 
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa nhà này không?')"
                                        title="Xóa">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <style>
            .tooltip {
                position: relative;
            }
            
            .tooltip:hover:after {
                content: attr(title);
                position: absolute;
                bottom: 100%;
                left: 50%;
                transform: translateX(-50%);
                background: rgba(0,0,0,0.7);
                color: white;
                padding: 4px 8px;
                border-radius: 4px;
                font-size: 12px;
                white-space: nowrap;
                margin-bottom: 5px;
            }
            
            .tooltip:hover:before {
                content: '';
                position: absolute;
                bottom: 100%;
                left: 50%;
                transform: translateX(-50%);
                border-width: 5px;
                border-style: solid;
                border-color: rgba(0,0,0,0.7) transparent transparent transparent;
                rotate: 180deg;
            }
        </style>
    @endif
@endsection 

@push('scripts')
<script>
    function shareSearchResults() {
        // Lấy URL hiện tại
        let currentUrl = window.location.href;
        
        // Tạo URL chia sẻ từ URL hiện tại
        let shareUrl = new URL('{{ route('houses.shared.search') }}');
        
        // Lấy tất cả tham số từ URL hiện tại
        let urlParams = new URL(currentUrl).searchParams;
        
        // Thêm user_id vào URL chia sẻ
        shareUrl.searchParams.append('user_id', '{{ Auth::id() }}');
        
        // Thêm các tham số tìm kiếm vào URL chia sẻ
        for (let param of urlParams.entries()) {
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
</script>
@endpush 