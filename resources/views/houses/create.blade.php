@extends('layouts.main')

@section('title', 'Thêm nhà mới')

@section('header')
    <div class="flex items-center">
        <i class="fas fa-plus-circle text-3xl mr-3"></i>
        <h1 class="text-2xl md:text-3xl font-bold">Thêm nhà cho thuê mới</h1>
    </div>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form method="POST" action="{{ route('houses.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Thông tin cơ bản -->
                    <div class="text-lg font-medium text-gray-900 mb-4">Thông tin cơ bản</div>
                    
                    <!-- Ga chính -->
                    <div class="mb-6 border-b pb-4">
                        <div class="flex items-center justify-between mb-2">
                            <x-input-label for="ga_chinh" :value="__('Ga chính')" class="text-base font-semibold" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="col-span-2">
                                <x-text-input id="ga_chinh" class="block w-full" type="text" name="ga_chinh" :value="old('ga_chinh')" placeholder="Nhập tên ga chính" />
                                <x-input-error :messages="$errors->get('ga_chinh')" class="mt-1" />
                            </div>
                            <div>
                                <select id="ga_chinh_house_type" name="ga_chinh_house_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                                    <option value="1R-1K" {{ old('ga_chinh_house_type') == '1R-1K' ? 'selected' : '' }}>1R-1K</option>
                                    <option value="2K-2DK" {{ old('ga_chinh_house_type') == '2K-2DK' ? 'selected' : '' }}>2K-2DK</option>
                                </select>
                                <x-input-error :messages="$errors->get('ga_chinh_house_type')" class="mt-1" />
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ga bên cạnh -->
                    <div class="mb-6 border-b pb-4">
                        <div class="flex items-center justify-between mb-2">
                            <x-input-label for="ga_ben_canh" :value="__('Ga bên cạnh')" class="text-base font-semibold" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="col-span-2">
                                <x-text-input id="ga_ben_canh" class="block w-full" type="text" name="ga_ben_canh" :value="old('ga_ben_canh')" placeholder="Nhập tên ga bên cạnh" />
                                <x-input-error :messages="$errors->get('ga_ben_canh')" class="mt-1" />
                            </div>
                            <div>
                                <select id="ga_ben_canh_house_type" name="ga_ben_canh_house_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                                    <option value="1R-1K" {{ old('ga_ben_canh_house_type') == '1R-1K' ? 'selected' : '' }}>1R-1K</option>
                                    <option value="2K-2DK" {{ old('ga_ben_canh_house_type') == '2K-2DK' ? 'selected' : '' }}>2K-2DK</option>
                                </select>
                                <x-input-error :messages="$errors->get('ga_ben_canh_house_type')" class="mt-1" />
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ga đi tàu tới -->
                    <div class="mb-6 border-b pb-4">
                        <div class="flex items-center justify-between mb-2">
                            <x-input-label for="ga_di_tau_toi" :value="__('Ga đi tàu tới')" class="text-base font-semibold" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="col-span-2">
                                <x-text-input id="ga_di_tau_toi" class="block w-full" type="text" name="ga_di_tau_toi" :value="old('ga_di_tau_toi')" placeholder="Nhập tên ga đi tàu tới" />
                                <x-input-error :messages="$errors->get('ga_di_tau_toi')" class="mt-1" />
                            </div>
                            <div>
                                <select id="ga_di_tau_toi_house_type" name="ga_di_tau_toi_house_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                                    <option value="1R-1K" {{ old('ga_di_tau_toi_house_type') == '1R-1K' ? 'selected' : '' }}>1R-1K</option>
                                    <option value="2K-2DK" {{ old('ga_di_tau_toi_house_type') == '2K-2DK' ? 'selected' : '' }}>2K-2DK</option>
                                </select>
                                <x-input-error :messages="$errors->get('ga_di_tau_toi_house_type')" class="mt-1" />
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin công ty -->
                    <div class="mb-6 border-b pb-4">
                        <div class="flex items-center justify-between mb-2">
                            <x-input-label for="is_company" :value="__('Là công ty')" class="text-base font-semibold" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="col-span-2">
                                <label class="inline-flex items-center">
                                    <input id="is_company" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="is_company" value="1" {{ old('is_company') ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Nhà này thuộc công ty') }}</span>
                                </label>
                                <x-input-error :messages="$errors->get('is_company')" class="mt-1" />
                            </div>
                            <div>
                                <select id="company_house_type" name="company_house_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                                    <option value="1R-1K" {{ old('company_house_type') == '1R-1K' ? 'selected' : '' }}>1R-1K</option>
                                    <option value="2K-2DK" {{ old('company_house_type') == '2K-2DK' ? 'selected' : '' }}>2K-2DK</option>
                                </select>
                                <x-input-error :messages="$errors->get('company_house_type')" class="mt-1" />
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mô tả chi tiết -->
                    <div class="mb-6">
                        <x-input-label for="description" :value="__('Mô tả chi tiết')" class="text-base font-semibold mb-2" />
                        <textarea id="description" name="description" rows="4" 
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                            placeholder="Nhập mô tả chi tiết về nhà cho thuê...">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Chi tiết phòng -->
                    <div class="text-lg font-medium text-gray-900 mt-8 mb-4">Chi tiết phòng</div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Loại nhà mặc định -->
                        <div class="mb-4">
                            <x-input-label for="default_house_type" :value="__('Loại nhà mặc định')" />
                            <select id="default_house_type" name="default_house_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="1R-1K" {{ old('default_house_type') == '1R-1K' ? 'selected' : '' }}>1R-1K</option>
                                <option value="2K-2DK" {{ old('default_house_type') == '2K-2DK' ? 'selected' : '' }}>2K-2DK</option>
                            </select>
                            <x-input-error :messages="$errors->get('default_house_type')" class="mt-2" />
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Khoảng cách đến ga -->
                        <div class="mb-4">
                            <x-input-label for="distance_to_station" :value="__('Khoảng cách đến ga (phút đi bộ)')" />
                            <x-text-input id="distance_to_station" class="block mt-1 w-full" type="number" name="distance_to_station" :value="old('distance_to_station')" min="0" />
                            <x-input-error :messages="$errors->get('distance_to_station')" class="mt-2" />
                        </div>
                    </div>
                    
                    <!-- Phương tiện đi lại -->
                    <div class="mb-4">
                        <x-input-label for="transportation" :value="__('Phương tiện đi lại')" />
                        <div class="mt-2 flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="transportation" value="Đi bộ" class="text-indigo-600 border-gray-300" {{ old('transportation') == 'Đi bộ' ? 'checked' : '' }} checked>
                                <span class="ml-2 text-sm text-gray-600"><i class="fas fa-walking mr-1"></i> Đi bộ</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="transportation" value="Xe đạp" class="text-indigo-600 border-gray-300" {{ old('transportation') == 'Xe đạp' ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600"><i class="fas fa-bicycle mr-1"></i> Xe đạp</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="transportation" value="Tàu" class="text-indigo-600 border-gray-300" {{ old('transportation') == 'Tàu' ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600"><i class="fas fa-train mr-1"></i> Tàu</span>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('transportation')" class="mt-2" />
                    </div>
                    
                    <!-- Chi tiết chi phí -->
                    <div class="text-lg font-medium text-gray-900 mt-8 mb-4">Chi tiết chi phí</div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Giá thuê -->
                        <div class="mb-4">
                            <x-input-label for="rent_price" :value="__('Giá thuê (yên/tháng)')" />
                            <x-text-input id="rent_price" class="block mt-1 w-full" type="number" name="rent_price" :value="old('rent_price')" min="0" required />
                            <x-input-error :messages="$errors->get('rent_price')" class="mt-2" />
                        </div>
                        
                        <!-- Tiền đầu vào -->
                        <div class="mb-4">
                            <x-input-label for="input_price" :value="__('Tiền đầu vào (yên)')" />
                            <x-text-input id="input_price" class="block mt-1 w-full" type="number" name="input_price" :value="old('input_price')" min="0" />
                            <x-input-error :messages="$errors->get('input_price')" class="mt-2" />
                        </div>
                    </div>
                    
                    <!-- Ảnh nhà -->
                    <div class="text-lg font-medium text-gray-900 mt-8 mb-4">Ảnh nhà</div>
                    
                    <!-- Ảnh chính -->
                    <div class="mb-4">
                        <x-input-label for="image" :value="__('Ảnh chính')" />
                        <input type="file" id="image" name="image" accept="image/*" 
                            class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                        <p class="text-xs text-gray-500 mt-1">Chấp nhận các định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB</p>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />

                        <!-- Preview ảnh chính -->
                        <div id="image-preview" class="mt-2 hidden w-full max-w-xs h-48 rounded-lg overflow-hidden border border-gray-300">
                            <img src="" alt="Ảnh xem trước" class="w-full h-full object-cover">
                        </div>
                    </div>
                    
                    <!-- Ảnh bổ sung -->
                    <div class="mb-4">
                        <x-input-label for="additional_images" :value="__('Ảnh bổ sung')" />
                        <input type="file" id="additional_images" name="additional_images[]" class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer" accept="image/*" multiple>
                        <p class="text-xs text-gray-500 mt-1">Bạn có thể chọn nhiều ảnh cùng lúc. Chấp nhận các định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB mỗi ảnh</p>
                        <x-input-error :messages="$errors->get('additional_images.*')" class="mt-2" />

                        <!-- Preview ảnh bổ sung -->
                        <div id="additional-images-preview" class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4">
                        </div>
                    </div>
                    
                    <!-- Link chia sẻ -->
                    <div class="mb-4">
                        <x-input-label for="share_link" :value="__('Link chia sẻ (tùy chọn)')" />
                        <x-text-input id="share_link" class="block mt-1 w-full" type="text" name="share_link" :value="old('share_link')" />
                        <x-input-error :messages="$errors->get('share_link')" class="mt-2" />
                        <p class="mt-1 text-sm text-gray-500">Nếu để trống, hệ thống sẽ tự động tạo link</p>
                    </div>
                    
                    <!-- Nút submit -->
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Thêm nhà') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection 