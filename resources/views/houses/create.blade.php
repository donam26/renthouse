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
                    
                    <!-- Tên nhà -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Tên nhà')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Địa chỉ -->
                    <div class="mb-4">
                        <x-input-label for="address" :value="__('Địa chỉ')" />
                        <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <!-- Khu vực -->
                    <div class="mb-4">
                        <x-input-label for="location" :value="__('Khu vực (Tokyo, Osaka, ...)')" />
                        <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" />
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    <!-- Chi tiết phòng -->
                    <div class="text-lg font-medium text-gray-900 mt-8 mb-4">Chi tiết phòng</div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Loại nhà -->
                        <div class="mb-4">
                            <x-input-label for="house_type" :value="__('Loại nhà')" />
                            <select id="house_type" name="house_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="1R" {{ old('house_type') == '1R' ? 'selected' : '' }}>1R</option>
                                <option value="1K" {{ old('house_type') == '1K' ? 'selected' : '' }}>1K</option>
                                <option value="1DK" {{ old('house_type') == '1DK' ? 'selected' : '' }}>1DK</option>
                                <option value="1LDK" {{ old('house_type') == '1LDK' ? 'selected' : '' }}>1LDK</option>
                                <option value="2K" {{ old('house_type') == '2K' ? 'selected' : '' }}>2K</option>
                                <option value="2DK" {{ old('house_type') == '2DK' ? 'selected' : '' }}>2DK</option>
                                <option value="2LDK" {{ old('house_type') == '2LDK' ? 'selected' : '' }}>2LDK</option>
                                <option value="3DK" {{ old('house_type') == '3DK' ? 'selected' : '' }}>3DK</option>
                                <option value="3LDK" {{ old('house_type') == '3LDK' ? 'selected' : '' }}>3LDK</option>
                            </select>
                            <x-input-error :messages="$errors->get('house_type')" class="mt-2" />
                        </div>
                        
                        <!-- Diện tích -->
                        <div class="mb-4">
                            <x-input-label for="size" :value="__('Diện tích (m²)')" />
                            <x-text-input id="size" class="block mt-1 w-full" type="number" name="size" :value="old('size')" step="0.01" min="1" required />
                            <x-input-error :messages="$errors->get('size')" class="mt-2" />
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Tầng -->
                        <div class="mb-4">
                            <x-input-label for="floor" :value="__('Tầng')" />
                            <x-text-input id="floor" class="block mt-1 w-full" type="number" name="floor" :value="old('floor')" min="1" />
                            <x-input-error :messages="$errors->get('floor')" class="mt-2" />
                        </div>
                        
                        <!-- Có gác lửng -->
                        <div class="mb-4">
                            <div class="block mt-4">
                                <label for="has_loft" class="inline-flex items-center">
                                    <input id="has_loft" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="has_loft" value="1" {{ old('has_loft') ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Có gác lửng') }}</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Trạng thái -->
                        <div class="mb-4">
                            <x-input-label for="status" :value="__('Trạng thái')" />
                            <select id="status" name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Còn trống</option>
                                <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>Đã cho thuê</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Ga gần nhất -->
                        <div class="mb-4">
                            <x-input-label for="nearest_station" :value="__('Ga gần nhất')" />
                            <x-text-input id="nearest_station" class="block mt-1 w-full" type="text" name="nearest_station" :value="old('nearest_station')" />
                            <x-input-error :messages="$errors->get('nearest_station')" class="mt-2" />
                        </div>
                        
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
                        
                        <!-- Tiền đặt cọc -->
                        <div class="mb-4">
                            <x-input-label for="deposit_price" :value="__('Tiền đặt cọc (yên)')" />
                            <x-text-input id="deposit_price" class="block mt-1 w-full" type="number" name="deposit_price" :value="old('deposit_price')" min="0" />
                            <x-input-error :messages="$errors->get('deposit_price')" class="mt-2" />
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Chi phí ban đầu -->
                        <div class="mb-4">
                            <x-input-label for="initial_cost" :value="__('Chi phí ban đầu tổng cộng (yên)')" />
                            <x-text-input id="initial_cost" class="block mt-1 w-full" type="number" name="initial_cost" :value="old('initial_cost')" min="0" />
                            <x-input-error :messages="$errors->get('initial_cost')" class="mt-2" />
                        </div>
                        
                        <!-- Phí đỗ xe -->
                        <div class="mb-4">
                            <x-input-label for="parking_fee" :value="__('Phí đỗ xe (yên/tháng)')" />
                            <x-text-input id="parking_fee" class="block mt-1 w-full" type="number" name="parking_fee" :value="old('parking_fee')" min="0" />
                            <x-input-error :messages="$errors->get('parking_fee')" class="mt-2" />
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Tiền lễ -->
                        <div class="mb-4">
                            <x-input-label for="key_money" :value="__('Tiền lễ (yên)')" />
                            <x-text-input id="key_money" class="block mt-1 w-full" type="number" name="key_money" :value="old('key_money')" min="0" />
                            <x-input-error :messages="$errors->get('key_money')" class="mt-2" />
                        </div>
                        
                        <!-- Phí bảo lãnh -->
                        <div class="mb-4">
                            <x-input-label for="guarantee_fee" :value="__('Phí bảo lãnh (yên)')" />
                            <x-text-input id="guarantee_fee" class="block mt-1 w-full" type="number" name="guarantee_fee" :value="old('guarantee_fee')" min="0" />
                            <x-input-error :messages="$errors->get('guarantee_fee')" class="mt-2" />
                        </div>
                        
                        <!-- Phí bảo hiểm -->
                        <div class="mb-4">
                            <x-input-label for="insurance_fee" :value="__('Phí bảo hiểm (yên)')" />
                            <x-text-input id="insurance_fee" class="block mt-1 w-full" type="number" name="insurance_fee" :value="old('insurance_fee')" min="0" />
                            <x-input-error :messages="$errors->get('insurance_fee')" class="mt-2" />
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Phí hồ sơ -->
                        <div class="mb-4">
                            <x-input-label for="document_fee" :value="__('Phí hồ sơ (yên)')" />
                            <x-text-input id="document_fee" class="block mt-1 w-full" type="number" name="document_fee" :value="old('document_fee')" min="0" />
                            <x-input-error :messages="$errors->get('document_fee')" class="mt-2" />
                        </div>
                        
                        <!-- Tiền thuê tháng đầu đã bao gồm -->
                        <div class="mb-4">
                            <div class="block mt-4">
                                <label for="rent_included" class="inline-flex items-center">
                                    <input id="rent_included" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="rent_included" value="1" {{ old('rent_included', '1') ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Tiền thuê tháng đầu đã bao gồm trong chi phí ban đầu') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tiện ích -->
                    <div class="text-lg font-medium text-gray-900 mt-8 mb-4">Tiện ích</div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Điều hòa -->
                        <div class="mb-4">
                            <div class="block">
                                <label for="amenities[air_conditioner]" class="inline-flex items-center">
                                    <input id="amenities[air_conditioner]" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="amenities[air_conditioner]" value="1" {{ old('amenities.air_conditioner') ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Điều hòa') }}</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Tủ lạnh -->
                        <div class="mb-4">
                            <div class="block">
                                <label for="amenities[refrigerator]" class="inline-flex items-center">
                                    <input id="amenities[refrigerator]" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="amenities[refrigerator]" value="1" {{ old('amenities.refrigerator') ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Tủ lạnh') }}</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Máy giặt -->
                        <div class="mb-4">
                            <div class="block">
                                <label for="amenities[washing_machine]" class="inline-flex items-center">
                                    <input id="amenities[washing_machine]" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="amenities[washing_machine]" value="1" {{ old('amenities.washing_machine') ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Máy giặt') }}</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Internet -->
                        <div class="mb-4">
                            <div class="block">
                                <label for="amenities[internet]" class="inline-flex items-center">
                                    <input id="amenities[internet]" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="amenities[internet]" value="1" {{ old('amenities.internet') ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Internet') }}</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Nội thất -->
                        <div class="mb-4">
                            <div class="block">
                                <label for="amenities[furniture]" class="inline-flex items-center">
                                    <input id="amenities[furniture]" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="amenities[furniture]" value="1" {{ old('amenities.furniture') ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Nội thất') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mô tả và ảnh -->
                    <div class="text-lg font-medium text-gray-900 mt-8 mb-4">Mô tả và ảnh</div>
                    
                    <!-- Mô tả -->
                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Mô tả')" />
                        <textarea id="description" name="description" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                    
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