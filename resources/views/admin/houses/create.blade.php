@extends('layouts.admin')

@section('title', 'Thêm nhà cho thuê mới')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Thêm nhà cho thuê mới</h1>
        <a href="{{ route('admin.houses.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại
        </a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <form action="{{ route('admin.houses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <!-- Tên nhà -->
                    <div class="sm:col-span-3">
                        <label for="name" class="block text-sm font-medium text-gray-700">Tên nhà</label>
                        <div class="mt-1">
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('name') border-red-500 @enderror">
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Địa chỉ -->
                    <div class="sm:col-span-3">
                        <label for="address" class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                        <div class="mt-1">
                            <input type="text" name="address" id="address" value="{{ old('address') }}" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('address') border-red-500 @enderror">
                        </div>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Giá thuê -->
                    <div class="sm:col-span-2">
                        <label for="rent_price" class="block text-sm font-medium text-gray-700">Giá thuê (VND)</label>
                        <div class="mt-1">
                            <input type="number" name="rent_price" id="rent_price" value="{{ old('rent_price') }}" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('rent_price') border-red-500 @enderror">
                        </div>
                        @error('rent_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Giá đặt cọc -->
                    <div class="sm:col-span-2">
                        <label for="deposit_price" class="block text-sm font-medium text-gray-700">Giá đặt cọc (VND)</label>
                        <div class="mt-1">
                            <input type="number" name="deposit_price" id="deposit_price" value="{{ old('deposit_price') }}"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('deposit_price') border-red-500 @enderror">
                        </div>
                        @error('deposit_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Dạng nhà -->
                    <div class="sm:col-span-2">
                        <label for="house_type" class="block text-sm font-medium text-gray-700">Dạng nhà</label>
                        <div class="mt-1">
                            <select id="house_type" name="house_type" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('house_type') border-red-500 @enderror">
                                <option value="">-- Chọn dạng nhà --</option>
                                <option value="1r" {{ old('house_type') == '1r' ? 'selected' : '' }}>1r</option>
                                <option value="1k" {{ old('house_type') == '1k' ? 'selected' : '' }}>1k</option>
                                <option value="1DK" {{ old('house_type') == '1DK' ? 'selected' : '' }}>1DK</option>
                                <option value="2K" {{ old('house_type') == '2K' ? 'selected' : '' }}>2K</option>
                                <option value="2DK" {{ old('house_type') == '2DK' ? 'selected' : '' }}>2DK</option>
                            </select>
                        </div>
                        @error('house_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Khoảng cách -->
                    <div class="sm:col-span-2">
                        <label for="distance" class="block text-sm font-medium text-gray-700">Khoảng cách (m)</label>
                        <div class="mt-1">
                            <input type="number" step="0.01" name="distance" id="distance" value="{{ old('distance') }}"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('distance') border-red-500 @enderror">
                        </div>
                        @error('distance')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phương tiện đi lại -->
                    <div class="sm:col-span-2">
                        <label for="transportation" class="block text-sm font-medium text-gray-700">Phương tiện đi lại</label>
                        <div class="mt-1">
                            <select id="transportation" name="transportation"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('transportation') border-red-500 @enderror">
                                <option value="">-- Chọn phương tiện --</option>
                                <option value="Đi bộ" {{ old('transportation') == 'Đi bộ' ? 'selected' : '' }}>Đi bộ</option>
                                <option value="Xe đạp" {{ old('transportation') == 'Xe đạp' ? 'selected' : '' }}>Xe đạp</option>
                                <option value="Tàu" {{ old('transportation') == 'Tàu' ? 'selected' : '' }}>Tàu</option>
                            </select>
                        </div>
                        @error('transportation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Chủ nhà -->
                    <div class="sm:col-span-2">
                        <label for="user_id" class="block text-sm font-medium text-gray-700">Chủ nhà</label>
                        <div class="mt-1">
                            <select id="user_id" name="user_id" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('user_id') border-red-500 @enderror">
                                <option value="">-- Chọn chủ nhà --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('user_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Trạng thái -->
                    <div class="sm:col-span-2">
                        <label for="status" class="block text-sm font-medium text-gray-700">Trạng thái</label>
                        <div class="mt-1">
                            <select id="status" name="status" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('status') border-red-500 @enderror">
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Còn trống</option>
                                <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>Đã thuê</option>
                            </select>
                        </div>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Hình ảnh -->
                    <div class="sm:col-span-6">
                        <label for="image" class="block text-sm font-medium text-gray-700">Hình ảnh</label>
                        <div class="mt-1 flex items-center">
                            <input type="file" name="image" id="image" accept="image/*"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 @error('image') border-red-500 @enderror">
                        </div>
                        <p class="mt-1 text-sm text-gray-500">JPG, PNG, GIF tối đa 2MB</p>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-5">
                    <div class="flex justify-end">
                        <a href="{{ route('admin.houses.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Hủy
                        </a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Tạo mới
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 