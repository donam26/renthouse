@extends('layouts.admin')

@section('title', 'Quản lý nhà cho thuê')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="section-header">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Quản lý nhà cho thuê</h1>
            <p class="mt-1 text-sm text-gray-600">Danh sách tất cả nhà cho thuê trong hệ thống</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.houses.create') }}" class="btn-primary inline-flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Thêm nhà mới
            </a>
        </div>
    </div>

    <!-- Tìm kiếm và lọc -->
    <div class="filter-container" x-data="{ openFilter: false }">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold flex items-center text-gray-800">
                <i class="fas fa-filter mr-2 text-indigo-500"></i> Bộ lọc tìm kiếm
            </h2>
            <button @click="openFilter = !openFilter" class="text-gray-500 hover:text-indigo-600 focus:outline-none md:hidden">
                <i x-show="!openFilter" class="fas fa-chevron-down"></i>
                <i x-show="openFilter" class="fas fa-chevron-up"></i>
            </button>
        </div>

        <form action="{{ route('admin.houses.index') }}" method="GET" 
            :class="{'hidden md:block': !openFilter, 'block': openFilter}">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Tìm kiếm theo tên, địa chỉ -->
                <div>
                    <label for="search" class="form-label">Tìm kiếm</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                            class="input-field pl-10"
                            placeholder="Tìm theo tên, địa chỉ...">
                    </div>
                </div>

                <!-- Lọc theo chủ nhà -->
                <div>
                    <label for="user_id" class="form-label">Chủ nhà</label>
                    <select id="user_id" name="user_id" class="input-field">
                        <option value="">Tất cả chủ nhà</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Lọc theo trạng thái -->
                <div>
                    <label for="status" class="form-label">Trạng thái</label>
                    <select id="status" name="status" class="input-field">
                        <option value="">Tất cả trạng thái</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Còn trống</option>
                        <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Đã thuê</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Lọc theo khoảng giá thuê -->
                <div>
                    <label for="min_price" class="form-label">Giá thuê từ</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                            VND
                        </span>
                        <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" 
                            class="flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            placeholder="Giá tối thiểu">
                    </div>
                </div>

                <div>
                    <label for="max_price" class="form-label">Đến</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                            VND
                        </span>
                        <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" 
                            class="flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            placeholder="Giá tối đa">
                    </div>
                </div>

                <!-- Lọc theo dạng nhà -->
                <div>
                    <label for="house_type" class="form-label">Dạng nhà</label>
                    <select id="house_type" name="house_type" class="input-field">
                        <option value="">Tất cả</option>
                        <option value="1K" {{ request('house_type') == '1K' ? 'selected' : '' }}>1K</option>
                        <option value="2K-2DK" {{ request('house_type') == '2K-2DK' ? 'selected' : '' }}>2K-2DK</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200">
                <button type="reset" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 focus:outline-none focus:underline">
                    <i class="fas fa-undo mr-1"></i> Đặt lại
                </button>
                <div class="flex items-center space-x-2">
                    <div class="inline-flex items-center">
                        <span class="text-gray-500 text-sm mr-2">Sắp xếp theo:</span>
                        <select name="sort_by" class="text-sm border-gray-300 rounded-md focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 pl-3 pr-8 shadow-sm bg-white">
                            <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="oldest" {{ request('sort_by') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                            <option value="price_low" {{ request('sort_by') == 'price_low' ? 'selected' : '' }}>Giá thấp đến cao</option>
                            <option value="price_high" {{ request('sort_by') == 'price_high' ? 'selected' : '' }}>Giá cao đến thấp</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-primary flex items-center">
                        <i class="fas fa-search mr-2"></i> Apply
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Bảng danh sách nhà -->
    <div class="table-container card">
        <ul role="list" class="divide-y divide-gray-200">
            @forelse($houses as $house)
                <li class="table-row">
                    <div class="block">
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="min-w-0 flex-1 flex items-center">
                                <div class="flex-shrink-0 h-16 w-16 rounded-md overflow-hidden bg-gray-100">
                                    @if($house->image_path)
                                        <img src="{{ asset('storage/' . $house->image_path) }}" alt="{{ $house->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-home text-3xl text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1 px-4">
                                    <div>
                                        <div class="flex items-center">
                                            <p class="text-sm font-medium text-indigo-600 truncate">{{ $house->name }}</p>
                                            <span class="ml-2 badge {{ $house->status === 'available' ? 'badge-success' : 'badge-danger' }}">
                                                {{ $house->status === 'available' ? 'Còn trống' : 'Đã thuê' }}
                                            </span>
                                            <span class="ml-2 badge badge-info">
                                                {{ $house->house_type }}
                                            </span>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500 flex items-center">
                                            <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
                                            {{ $house->address }}
                                        </p>
                                        <div class="mt-1 flex items-center">
                                            <p class="text-sm text-gray-500 mr-4 flex items-center">
                                                <i class="fas fa-user mr-1 text-gray-400"></i>
                                                {{ $house->user->name }}
                                            </p>
                                            <p class="text-sm text-gray-500 mr-4 flex items-center">
                                                <i class="fas fa-money-bill-wave mr-1 text-gray-400"></i>
                                                {{ number_format($house->rent_price) }} VND
                                            </p>
                                            <p class="text-sm text-gray-500 flex items-center">
                                                <i class="fas fa-calendar-alt mr-1 text-gray-400"></i>
                                                {{ $house->created_at->format('d/m/Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('admin.houses.show', $house) }}" class="icon-button icon-button-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.houses.edit', $house) }}" class="icon-button icon-button-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.houses.destroy', $house) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="icon-button icon-button-delete" 
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa nhà này?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-4 py-6 text-center text-gray-500">
                    <div class="flex flex-col items-center justify-center py-8">
                        <i class="fas fa-home text-5xl text-gray-300 mb-4"></i>
                        <p class="text-lg font-medium text-gray-600">Không tìm thấy nhà cho thuê nào</p>
                        <p class="mt-1 text-sm text-gray-500">Thử thay đổi bộ lọc hoặc thêm nhà mới</p>
                    </div>
                </li>
            @endforelse
        </ul>
    </div>

    <!-- Phân trang -->
    <div class="mt-4">
        {{ $houses->links() }}
    </div>
</div>
@endsection 