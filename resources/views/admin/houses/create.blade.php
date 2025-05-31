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
                  
                    <!-- Giá thuê -->
                    <div class="sm:col-span-2">
                        <label for="rent_price" class="block text-sm font-medium text-gray-700">Giá thuê (¥)</label>
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
                        <label for="input_price" class="block text-sm font-medium text-gray-700">Giá đặt cọc (¥)</label>
                        <div class="mt-1">
                            <input type="number" name="input_price" id="input_price" value="{{ old('input_price') }}"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('input_price') border-red-500 @enderror">
                        </div>
                        @error('input_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Dạng nhà mặc định -->
                    <div class="sm:col-span-2">
                        <label for="default_house_type" class="block text-sm font-medium text-gray-700">Dạng nhà mặc định</label>
                        <div class="mt-1">
                            <select id="default_house_type" name="default_house_type" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('default_house_type') border-red-500 @enderror">
                                <option value="">-- Chọn dạng nhà --</option>
                                <option value="1R-1K" {{ old('default_house_type') == '1R-1K' ? 'selected' : '' }}>1R-1K</option>
                                <option value="2K-2DK" {{ old('default_house_type') == '2K-2DK' ? 'selected' : '' }}>2K-2DK</option>
                            </select>
                        </div>
                        @error('default_house_type')
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

                    <!-- Thông tin ga tàu và loại nhà -->
                    <div class="sm:col-span-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Cấu hình loại nhà cho từng ga</h3>
                    </div>

                    <!-- Ga chính -->
                    <div class="sm:col-span-3">
                        <label for="ga_chinh" class="block text-sm font-medium text-gray-700">Ga chính</label>
                        <div class="mt-1">
                            <input type="text" name="ga_chinh" id="ga_chinh" value="{{ old('ga_chinh') }}" 
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('ga_chinh') border-red-500 @enderror"
                                placeholder="Nhập tên ga chính">
                        </div>
                        @error('ga_chinh')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="ga_chinh_house_type" class="block text-sm font-medium text-gray-700">Loại nhà (ga chính)</label>
                        <div class="mt-1">
                            <select id="ga_chinh_house_type" name="ga_chinh_house_type"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('ga_chinh_house_type') border-red-500 @enderror">
                                <option value="">-- Chọn loại nhà --</option>
                                <option value="1R-1K" {{ old('ga_chinh_house_type') == '1R-1K' ? 'selected' : '' }}>1R-1K</option>
                                <option value="2K-2DK" {{ old('ga_chinh_house_type') == '2K-2DK' ? 'selected' : '' }}>2K-2DK</option>
                            </select>
                        </div>
                        @error('ga_chinh_house_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ga bên cạnh -->
                    <div class="sm:col-span-3">
                        <label for="ga_ben_canh" class="block text-sm font-medium text-gray-700">Ga bên cạnh</label>
                        <div class="mt-1">
                            <input type="text" name="ga_ben_canh" id="ga_ben_canh" value="{{ old('ga_ben_canh') }}" 
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('ga_ben_canh') border-red-500 @enderror"
                                placeholder="Nhập tên ga bên cạnh">
                        </div>
                        @error('ga_ben_canh')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="ga_ben_canh_house_type" class="block text-sm font-medium text-gray-700">Loại nhà (ga bên cạnh)</label>
                        <div class="mt-1">
                            <select id="ga_ben_canh_house_type" name="ga_ben_canh_house_type"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('ga_ben_canh_house_type') border-red-500 @enderror">
                                <option value="">-- Chọn loại nhà --</option>
                                <option value="1R-1K" {{ old('ga_ben_canh_house_type') == '1R-1K' ? 'selected' : '' }}>1R-1K</option>
                                <option value="2K-2DK" {{ old('ga_ben_canh_house_type') == '2K-2DK' ? 'selected' : '' }}>2K-2DK</option>
                            </select>
                        </div>
                        @error('ga_ben_canh_house_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ga đi tàu tới -->
                    <div class="sm:col-span-3">
                        <label for="ga_di_tau_toi" class="block text-sm font-medium text-gray-700">Ga đi tàu tới</label>
                        <div class="mt-1">
                            <input type="text" name="ga_di_tau_toi" id="ga_di_tau_toi" value="{{ old('ga_di_tau_toi') }}" 
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('ga_di_tau_toi') border-red-500 @enderror"
                                placeholder="Nhập tên ga đi tàu tới">
                        </div>
                        @error('ga_di_tau_toi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="ga_di_tau_toi_house_type" class="block text-sm font-medium text-gray-700">Loại nhà (ga đi tàu tới)</label>
                        <div class="mt-1">
                            <select id="ga_di_tau_toi_house_type" name="ga_di_tau_toi_house_type"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('ga_di_tau_toi_house_type') border-red-500 @enderror">
                                <option value="">-- Chọn loại nhà --</option>
                                <option value="1R-1K" {{ old('ga_di_tau_toi_house_type') == '1R-1K' ? 'selected' : '' }}>1R-1K</option>
                                <option value="2K-2DK" {{ old('ga_di_tau_toi_house_type') == '2K-2DK' ? 'selected' : '' }}>2K-2DK</option>
                            </select>
                        </div>
                        @error('ga_di_tau_toi_house_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Công ty -->
                    <div class="sm:col-span-3">
                        <label for="is_company" class="block text-sm font-medium text-gray-700">Công ty</label>
                        <div class="mt-1">
                            <div class="flex items-center">
                                <input id="is_company" name="is_company" type="checkbox" value="1" {{ old('is_company') ? 'checked' : '' }}
                                    class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="is_company" class="ml-2 block text-sm text-gray-700">
                                    Nhà này thuộc công ty
                                </label>
                            </div>
                        </div>
                        @error('is_company')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="company_house_type" class="block text-sm font-medium text-gray-700">Loại nhà (công ty)</label>
                        <div class="mt-1">
                            <select id="company_house_type" name="company_house_type"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('company_house_type') border-red-500 @enderror">
                                <option value="">-- Chọn loại nhà --</option>
                                <option value="1R-1K" {{ old('company_house_type') == '1R-1K' ? 'selected' : '' }}>1R-1K</option>
                                <option value="2K-2DK" {{ old('company_house_type') == '2K-2DK' ? 'selected' : '' }}>2K-2DK</option>
                            </select>
                        </div>
                        @error('company_house_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mô tả chi tiết -->
                    <div class="sm:col-span-6">
                        <label for="description" class="block text-sm font-medium text-gray-700">Mô tả chi tiết</label>
                        <div class="mt-1">
                            <textarea id="description" name="description" rows="4"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('description') border-red-500 @enderror"
                                placeholder="Nhập mô tả chi tiết về nhà cho thuê...">{{ old('description') }}</textarea>
                        </div>
                        @error('description')
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