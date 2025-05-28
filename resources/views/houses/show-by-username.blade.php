@extends('layouts.main')

@section('title', 'Danh sách nhà cho thuê của ' . $user->name)

@section('header')
    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold">Bất động sản của {{ $user->name }}</h1>
            @if ($user->company_name)
                <p class="text-gray-100 mt-1">{{ $user->company_name }}</p>
            @endif
        </div>
        @if (Auth::id() === $user->id)
            <a href="{{ route('houses.create') }}" class="btn-primary inline-flex items-center self-start">
                <i class="fas fa-plus-circle mr-2"></i> Thêm nhà mới
            </a>
        @endif
    </div>
@endsection

@section('content')
    <div class="mb-8">
        <div class="bg-white rounded-lg shadow p-6 flex flex-col md:flex-row gap-6 items-center">
            <div class="h-24 w-24 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white flex-shrink-0 shadow-md">
                <span class="text-4xl font-bold">{{ substr($user->name, 0, 1) }}</span>
            </div>
            
            <div class="flex-grow text-center md:text-left">
                <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
                @if ($user->company_name)
                    <p class="text-gray-600 mt-1 flex items-center justify-center md:justify-start font-medium">
                        <i class="fas fa-building mr-2 text-indigo-500"></i> {{ $user->company_name }}
                    </p>
                @endif
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
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-full p-2 mr-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">Đang cho thuê</span>
                        <p class="font-bold text-gray-800 text-lg">{{ $houses->where('status', 'rented')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-center mb-4">
            <i class="fas fa-filter text-indigo-600 mr-2"></i>
            <h2 class="text-lg font-medium text-gray-800">Bộ lọc tìm kiếm</h2>
        </div>
        
        <form action="{{ route('houses.by.username', $user->username) }}" method="GET">
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
                    <label for="distance_to_station" class="block mb-2 text-sm font-medium text-gray-700">Khoảng cách</label>
                    <div class="relative">
                        <input type="text" name="distance_to_station" id="distance_to_station" 
                            value="{{ request('distance_to_station') }}"
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
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">VND</span>
                        <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" 
                            class="block w-full rounded-none sm:text-sm border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="3000">
                    </div>
                </div>
                
                <!-- Giá thuê đến -->
                <div>
                    <label for="max_price" class="block mb-2 text-sm font-medium text-gray-700">Đến</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">VND</span>
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
                        @foreach(['1r', '1k', '1DK', '2K', '2DK'] as $type)
                            <label class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm cursor-pointer hover:bg-gray-50 {{ request('house_type') == $type ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'text-gray-700' }}">
                                <input type="radio" name="house_type" value="{{ $type }}" class="hidden" {{ request('house_type') == $type ? 'checked' : '' }}>
                                {{ $type }}
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Trạng thái -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Trạng thái</label>
                    <div class="space-y-2">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="status" value="available" class="sr-only" {{ request('status') == 'available' ? 'checked' : '' }}>
                            <span class="w-5 h-5 mr-2 rounded-full flex items-center justify-center {{ request('status') == 'available' ? 'bg-indigo-600 border-indigo-600' : 'bg-white border border-gray-300' }}">
                                <span class="{{ request('status') == 'available' ? 'w-2 h-2 bg-white rounded-full' : '' }}"></span>
                            </span>
                            <span class="flex items-center">
                                <span class="w-3 h-3 mr-2 bg-green-500 rounded-full"></span>
                                <span class="text-sm text-gray-700">Còn trống</span>
                            </span>
                        </label>
                        
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="status" value="rented" class="sr-only" {{ request('status') == 'rented' ? 'checked' : '' }}>
                            <span class="w-5 h-5 mr-2 rounded-full flex items-center justify-center {{ request('status') == 'rented' ? 'bg-indigo-600 border-indigo-600' : 'bg-white border border-gray-300' }}">
                                <span class="{{ request('status') == 'rented' ? 'w-2 h-2 bg-white rounded-full' : '' }}"></span>
                            </span>
                            <span class="flex items-center">
                                <span class="w-3 h-3 mr-2 bg-red-500 rounded-full"></span>
                                <span class="text-sm text-gray-700">Đã thuê</span>
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="mb-6">
                <!-- Phương tiện đi lại -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Phương tiện đi lại</label>
                    <div class="flex space-x-8">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="transportation" value="walking" class="sr-only" {{ request('transportation') == 'walking' ? 'checked' : '' }}>
                            <span class="w-5 h-5 mr-2 rounded-full flex items-center justify-center {{ request('transportation') == 'walking' ? 'bg-indigo-600 border-indigo-600' : 'bg-white border border-gray-300' }}">
                                <span class="{{ request('transportation') == 'walking' ? 'w-2 h-2 bg-white rounded-full' : '' }}"></span>
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-walking text-indigo-600 mr-2"></i>
                                <span class="text-sm text-gray-700">Đi bộ</span>
                            </span>
                        </label>
                        
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="transportation" value="bicycle" class="sr-only" {{ request('transportation') == 'bicycle' ? 'checked' : '' }}>
                            <span class="w-5 h-5 mr-2 rounded-full flex items-center justify-center {{ request('transportation') == 'bicycle' ? 'bg-indigo-600 border-indigo-600' : 'bg-white border border-gray-300' }}">
                                <span class="{{ request('transportation') == 'bicycle' ? 'w-2 h-2 bg-white rounded-full' : '' }}"></span>
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-bicycle text-indigo-600 mr-2"></i>
                                <span class="text-sm text-gray-700">Xe đạp</span>
                            </span>
                        </label>
                        
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="transportation" value="train" class="sr-only" {{ request('transportation') == 'train' ? 'checked' : '' }}>
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
                    <a href="{{ route('houses.by.username', $user->username) }}" class="inline-flex items-center py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-undo mr-2"></i> Đặt lại
                    </a>
                    <button type="submit" class="flex items-center justify-center py-2 px-5 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        <i class="fas fa-search mr-2"></i> Lọc kết quả
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
                                    <p class="text-sm text-gray-600">Khoảng cách:</p>
                                    <p class="font-medium text-gray-800">{{ $house->distance ? $house->distance . 'm' : '200.00m' }}</p>
                                    
                                    <div class="mt-2 flex items-center">
                                        <span class="text-sm text-gray-600 mr-2">Đi bộ:</span>
                                        @if ($house->transportation == 'Xe đạp')
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
                                    </div>
                                </div>
                                
                                <div class="col-span-3 md:col-span-1">
                                    <p class="text-sm text-gray-600">Giá thuê:</p>
                                    <p class="font-bold text-green-600 text-lg">{{ number_format($house->rent_price) }} <span class="text-sm font-normal">VND</span></p>
                                    
                                    @if ($house->deposit_price)
                                    <p class="text-sm text-gray-600 mt-1">Đặt cọc:</p>
                                    <p class="font-medium text-gray-800">{{ number_format($house->deposit_price) }} <span class="text-sm">VND</span></p>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Dạng nhà -->
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-1">Dạng nhà:</p>
                                <div class="flex space-x-2">
                                    @foreach(['1r', '1k', '1DK', '2K', '2DK'] as $type)
                                        <span class="px-3 py-1 text-xs rounded-md {{ $house->house_type === $type ? 'bg-blue-600 text-white font-bold' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $type }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Địa chỉ -->
                            <div class="mb-4">
                                <h3 class="font-bold text-lg text-gray-800">{{ $house->name }}</h3>
                                <p class="text-gray-600 flex items-start mt-1">
                                    <i class="fas fa-map-marker-alt mt-1 mr-2 text-indigo-500"></i>
                                    <span>{{ $house->address }}</span>
                                </p>
                            </div>
                            
                            <!-- Phần nút hành động -->
                            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                                <a href="{{ route('houses.show', $house) }}" class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                                    <span>Xem chi tiết</span>
                                    <i class="fas fa-arrow-right ml-1 text-sm"></i>
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