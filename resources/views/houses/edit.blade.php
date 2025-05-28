@extends('layouts.main')

@section('title', 'Chỉnh sửa nhà cho thuê - ' . $house->name)

@section('header')
    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold">Chỉnh sửa nhà cho thuê</h1>
            <p class="text-gray-100 mt-1">Cập nhật thông tin cho "{{ $house->name }}"</p>
        </div>
        <div>
            <a href="{{ route('houses.by.username', $house->user->username) }}" class="btn-secondary inline-flex items-center">
                <i class="fas fa-list mr-2"></i> Danh sách nhà
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Thông báo thành công -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
        
        <form action="{{ route('houses.update', $house) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Thông báo lỗi -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4">
                    <div class="font-medium text-red-700 mb-2">Đã có lỗi xảy ra:</div>
                    <ul class="text-red-600 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Cột thông tin cơ bản -->
                <div>
                    <h2 class="text-xl font-bold mb-4 text-gray-800">Thông tin cơ bản</h2>
                
                    <!-- Tên nhà -->
                    <div class="mb-4">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Tên gạ <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $house->name) }}" required
                            class="input-field @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Vị trí -->
                    <div class="mb-4">
                        <label for="location" class="block mb-2 text-sm font-medium text-gray-700">Vị trí (VD: Tokyo, OSAKA, etc.)</label>
                        <input type="text" id="location" name="location" value="{{ old('location', $house->location) }}"
                            class="input-field @error('location') border-red-500 @enderror">
                        @error('location')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Địa chỉ -->
                    <div class="mb-4">
                        <label for="address" class="block mb-2 text-sm font-medium text-gray-700">Địa chỉ <span class="text-red-500">*</span></label>
                        <input type="text" id="address" name="address" value="{{ old('address', $house->address) }}" required
                            class="input-field @error('address') border-red-500 @enderror">
                        @error('address')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Diện tích -->
                    <div class="mb-4">
                        <label for="size" class="block mb-2 text-sm font-medium text-gray-700">Diện tích (m²) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" id="size" name="size" value="{{ old('size', $house->size) }}" required
                            class="input-field @error('size') border-red-500 @enderror">
                        @error('size')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Cột thông tin khác -->
                <div>
                    <h2 class="text-xl font-bold mb-4 text-gray-800">Thông tin khác</h2>

                    <!-- Giá thuê -->
                    <div class="mb-4">
                        <label for="rent_price" class="block mb-2 text-sm font-medium text-gray-700">Giá thuê (yên/tháng) <span class="text-red-500">*</span></label>
                        <div class="flex items-center">
                            <span class="bg-gray-100 px-3 py-3 border border-gray-300 border-r-0 rounded-l-md text-gray-700">¥</span>
                            <input type="number" id="rent_price" name="rent_price" value="{{ old('rent_price', $house->rent_price) }}" required
                                class="input-field rounded-l-none @error('rent_price') border-red-500 @enderror">
                        </div>
                        @error('rent_price')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Giá đặt cọc -->
                    <div class="mb-4">
                        <label for="deposit_price" class="block mb-2 text-sm font-medium text-gray-700">Tiền đặt cọc (yên)</label>
                        <div class="flex items-center">
                            <span class="bg-gray-100 px-3 py-3 border border-gray-300 border-r-0 rounded-l-md text-gray-700">¥</span>
                            <input type="number" id="deposit_price" name="deposit_price" value="{{ old('deposit_price', $house->deposit_price) }}"
                                class="input-field rounded-l-none @error('deposit_price') border-red-500 @enderror">
                        </div>
                        @error('deposit_price')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Chi phí ban đầu -->
                    <div class="mb-4">
                        <label for="initial_cost" class="block mb-2 text-sm font-medium text-gray-700">Chi phí ban đầu tổng cộng (yên)</label>
                        <div class="flex items-center">
                            <span class="bg-gray-100 px-3 py-3 border border-gray-300 border-r-0 rounded-l-md text-gray-700">¥</span>
                            <input type="number" id="initial_cost" name="initial_cost" value="{{ old('initial_cost', $house->initial_cost) }}"
                                class="input-field rounded-l-none @error('initial_cost') border-red-500 @enderror">
                        </div>
                        @error('initial_cost')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Dạng nhà -->
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Dạng nhà</label>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach(['1R', '1K', '1DK', '1LDK', '2K', '2DK', '2LDK', '3DK', '3LDK'] as $type)
                                <label class="flex items-center justify-center p-2 border border-gray-300 rounded-md {{ old('house_type', $house->house_type) == $type ? 'bg-indigo-600 text-white' : '' }} hover:bg-indigo-100 cursor-pointer transition-colors">
                                    <input type="radio" name="house_type" value="{{ $type }}" class="hidden house-type-input" 
                                        {{ old('house_type', $house->house_type) == $type ? 'checked' : '' }}>
                                    <span>{{ $type }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('house_type')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Trạng thái -->
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Trạng thái <span class="text-red-500">*</span></label>
                        <div class="flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="status" value="available" class="text-indigo-600 focus:ring-indigo-500 h-5 w-5" 
                                    {{ old('status', $house->status) == 'available' ? 'checked' : '' }} required>
                                <span class="ml-2 text-gray-700">Còn trống</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="status" value="rented" class="text-indigo-600 focus:ring-indigo-500 h-5 w-5" 
                                    {{ old('status', $house->status) == 'rented' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Đã thuê</span>
                            </label>
                        </div>
                        @error('status')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Link chia sẻ -->
                    <div class="mb-4">
                        <label for="share_link" class="block mb-2 text-sm font-medium text-gray-700">Link chia sẻ</label>
                        <input type="text" id="share_link" name="share_link" value="{{ old('share_link', $house->share_link) }}"
                            class="input-field @error('share_link') border-red-500 @enderror">
                        @error('share_link')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Mô tả -->
            <div class="mb-6 mt-2">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Mô tả</h2>
                <label for="description" class="block mb-2 text-sm font-medium text-gray-700">Nội dung khác</label>
                <textarea id="description" name="description" rows="4"
                    class="input-field @error('description') border-red-500 @enderror">{{ old('description', $house->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Chi tiết phòng -->
            <div class="mb-6 mt-2">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Chi tiết phòng</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Tầng -->
                    <div class="mb-4">
                        <label for="floor" class="block mb-2 text-sm font-medium text-gray-700">Tầng</label>
                        <input type="number" id="floor" name="floor" min="1" max="50" 
                            value="{{ old('floor', $house->room_details['floor'] ?? '') }}"
                            class="input-field @error('floor') border-red-500 @enderror">
                        @error('floor')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Ga gần nhất -->
                    <div class="mb-4">
                        <label for="nearest_station" class="block mb-2 text-sm font-medium text-gray-700">Ga gần nhất</label>
                        <input type="text" id="nearest_station" name="nearest_station" 
                            value="{{ old('nearest_station', $house->room_details['nearest_station'] ?? '') }}"
                            class="input-field @error('nearest_station') border-red-500 @enderror">
                        @error('nearest_station')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Khoảng cách đến ga -->
                    <div class="mb-4">
                        <label for="distance_to_station" class="block mb-2 text-sm font-medium text-gray-700">Khoảng cách đến ga (phút đi bộ)</label>
                        <input type="number" id="distance_to_station" name="distance_to_station" min="0" max="60" 
                            value="{{ old('distance_to_station', $house->room_details['distance_to_station'] ?? '') }}"
                            class="input-field @error('distance_to_station') border-red-500 @enderror">
                        @error('distance_to_station')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Có gác lửng -->
                    <div class="mb-4">
                        <div class="flex items-center h-full mt-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="has_loft" value="1" 
                                    {{ old('has_loft', isset($house->room_details['has_loft']) && $house->room_details['has_loft']) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Có gác lửng</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chi tiết chi phí -->
            <div class="mb-6 mt-2">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Chi tiết chi phí</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Tiền lễ -->
                    <div class="mb-4">
                        <label for="key_money" class="block mb-2 text-sm font-medium text-gray-700">Tiền lễ (yên)</label>
                        <div class="flex items-center">
                            <span class="bg-gray-100 px-3 py-3 border border-gray-300 border-r-0 rounded-l-md text-gray-700">¥</span>
                            <input type="number" id="key_money" name="key_money" 
                                value="{{ old('key_money', $house->cost_details['key_money'] ?? '') }}"
                                class="input-field rounded-l-none @error('key_money') border-red-500 @enderror">
                        </div>
                        @error('key_money')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Phí bảo lãnh -->
                    <div class="mb-4">
                        <label for="guarantee_fee" class="block mb-2 text-sm font-medium text-gray-700">Phí bảo lãnh (yên)</label>
                        <div class="flex items-center">
                            <span class="bg-gray-100 px-3 py-3 border border-gray-300 border-r-0 rounded-l-md text-gray-700">¥</span>
                            <input type="number" id="guarantee_fee" name="guarantee_fee" 
                                value="{{ old('guarantee_fee', $house->cost_details['guarantee_fee'] ?? '') }}"
                                class="input-field rounded-l-none @error('guarantee_fee') border-red-500 @enderror">
                        </div>
                        @error('guarantee_fee')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Phí bảo hiểm -->
                    <div class="mb-4">
                        <label for="insurance_fee" class="block mb-2 text-sm font-medium text-gray-700">Phí bảo hiểm (yên)</label>
                        <div class="flex items-center">
                            <span class="bg-gray-100 px-3 py-3 border border-gray-300 border-r-0 rounded-l-md text-gray-700">¥</span>
                            <input type="number" id="insurance_fee" name="insurance_fee" 
                                value="{{ old('insurance_fee', $house->cost_details['insurance_fee'] ?? '') }}"
                                class="input-field rounded-l-none @error('insurance_fee') border-red-500 @enderror">
                        </div>
                        @error('insurance_fee')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Phí hồ sơ -->
                    <div class="mb-4">
                        <label for="document_fee" class="block mb-2 text-sm font-medium text-gray-700">Phí hồ sơ (yên)</label>
                        <div class="flex items-center">
                            <span class="bg-gray-100 px-3 py-3 border border-gray-300 border-r-0 rounded-l-md text-gray-700">¥</span>
                            <input type="number" id="document_fee" name="document_fee" 
                                value="{{ old('document_fee', $house->cost_details['document_fee'] ?? '') }}"
                                class="input-field rounded-l-none @error('document_fee') border-red-500 @enderror">
                        </div>
                        @error('document_fee')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Phí đỗ xe -->
                    <div class="mb-4">
                        <label for="parking_fee" class="block mb-2 text-sm font-medium text-gray-700">Phí đỗ xe (yên/tháng)</label>
                        <div class="flex items-center">
                            <span class="bg-gray-100 px-3 py-3 border border-gray-300 border-r-0 rounded-l-md text-gray-700">¥</span>
                            <input type="number" id="parking_fee" name="parking_fee" 
                                value="{{ old('parking_fee', $house->cost_details['parking_fee'] ?? '') }}"
                                class="input-field rounded-l-none @error('parking_fee') border-red-500 @enderror">
                        </div>
                        @error('parking_fee')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Tiền thuê tháng đầu đã bao gồm -->
                    <div class="mb-4">
                        <div class="flex items-center h-full mt-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="rent_included" value="1" 
                                    {{ old('rent_included', isset($house->cost_details['rent_included']) && $house->cost_details['rent_included']) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Tiền thuê tháng đầu đã bao gồm trong chi phí ban đầu</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tiện ích -->
            <div class="mb-6 mt-2">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Tiện ích</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Điều hòa -->
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="amenities[air_conditioner]" value="1" 
                                {{ old('amenities.air_conditioner', isset($house->amenities['air_conditioner']) && $house->amenities['air_conditioner']) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Điều hòa</span>
                        </label>
                    </div>
                    
                    <!-- Tủ lạnh -->
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="amenities[refrigerator]" value="1" 
                                {{ old('amenities.refrigerator', isset($house->amenities['refrigerator']) && $house->amenities['refrigerator']) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Tủ lạnh</span>
                        </label>
                    </div>
                    
                    <!-- Máy giặt -->
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="amenities[washing_machine]" value="1" 
                                {{ old('amenities.washing_machine', isset($house->amenities['washing_machine']) && $house->amenities['washing_machine']) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Máy giặt</span>
                        </label>
                    </div>
                    
                    <!-- Internet -->
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="amenities[internet]" value="1" 
                                {{ old('amenities.internet', isset($house->amenities['internet']) && $house->amenities['internet']) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Internet</span>
                        </label>
                    </div>
                    
                    <!-- Nội thất -->
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="amenities[furniture]" value="1" 
                                {{ old('amenities.furniture', isset($house->amenities['furniture']) && $house->amenities['furniture']) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Nội thất</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Ảnh nhà -->
            <div class="mb-6">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Ảnh nhà</h2>
                
                <!-- Ảnh chính hiện tại và các ảnh bổ sung -->
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-700 mb-2">Ảnh hiện tại:</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @if ($images->count() > 0)
                            @foreach($images as $image)
                                <div class="relative group" id="image-container-{{ $image->id }}">
                                    <div class="w-full h-40 rounded-lg overflow-hidden">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Ảnh nhà" class="w-full h-full object-cover">
                                    </div>
                                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center space-x-2">
                                        <button type="button" class="p-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 cursor-pointer" 
                                                onclick="setAsPrimary({{ $image->id }})" title="Đặt làm ảnh chính">
                                            <i class="fas fa-star"></i>
                                        </button>
                                        <button type="button" class="p-2 bg-red-600 text-white rounded-full hover:bg-red-700 cursor-pointer" 
                                                onclick="markForDeletion({{ $image->id }})" title="Đánh dấu xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="mt-1 text-xs text-center">
                                        <span id="image-status-{{ $image->id }}" 
                                              class="inline-block px-2 py-1 rounded-full {{ $image->is_primary ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $image->is_primary ? 'Ảnh chính' : 'Ảnh phụ' }}
                                        </span>
                                    </div>
                                    
                                    <!-- Hidden inputs for backend processing -->
                                    <input type="radio" name="primary_image_id" value="{{ $image->id }}" id="primary_image_{{ $image->id }}" 
                                           class="hidden" {{ $image->is_primary ? 'checked' : '' }}>
                                    <input type="checkbox" name="images_to_delete[]" value="{{ $image->id }}" id="delete_image_{{ $image->id }}" 
                                           class="hidden">
                                </div>
                            @endforeach
                        @elseif ($house->image_path)
                            <div class="w-full h-48 relative rounded-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $house->image_path) }}" alt="{{ $house->name }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent flex items-end">
                                    <p class="text-white text-xs p-3">{{ basename($house->image_path) }}</p>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500 col-span-4">Chưa có ảnh nào cho nhà này.</p>
                        @endif
                    </div>
                </div>
                
                <!-- Hiển thị danh sách ảnh đã chọn để xóa -->
                <div id="images-to-delete-container" class="mt-4 hidden bg-red-50 p-3 rounded-md">
                    <h3 class="text-sm font-medium text-red-700 mb-2">Ảnh đã đánh dấu để xóa:</h3>
                    <ul id="images-to-delete-list" class="text-sm text-red-600 space-y-1"></ul>
                    <button type="button" onclick="clearAllDeletions()" class="mt-2 text-xs text-red-700 underline">Hủy tất cả</button>
                </div>
            </div>

            <!-- Tải lên ảnh mới -->
            <div>
                <label for="image" class="block mb-2 text-sm font-medium text-gray-700">Cập nhật ảnh chính mới</label>
                <input type="file" id="image" name="image" accept="image/*" 
                    class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                <p class="text-xs text-gray-500 mt-1">Chấp nhận các định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB</p>
                @error('image')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tải lên nhiều ảnh bổ sung -->
            <div class="mt-4">
                <label for="additional_images" class="block mb-2 text-sm font-medium text-gray-700">Thêm ảnh bổ sung</label>
                <input type="file" id="additional_images" name="additional_images[]" accept="image/*" multiple
                    class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                <p class="text-xs text-gray-500 mt-1">Chọn nhiều ảnh cùng lúc. Chấp nhận các định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB mỗi ảnh</p>
                @error('additional_images.*')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nút lưu -->
            <div class="border-t border-gray-200 pt-6 flex justify-end space-x-2">
                <a href="{{ route('houses.show', $house) }}" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Quay lại chi tiết
                </a>
                <a href="{{ route('houses.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md shadow-md hover:bg-gray-700 transition">
                    <i class="fas fa-list mr-2"></i> Danh sách nhà
                </a>
                <button type="submit" class="btn-primary flex items-center">
                    <i class="fas fa-save mr-2"></i> Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
    
    <script>
        // Xử lý chọn loại nhà
        document.querySelectorAll('.house-type-input').forEach(input => {
            input.addEventListener('change', function() {
                // Reset tất cả các label về trạng thái không chọn
                document.querySelectorAll('.house-type-input').forEach(radio => {
                    radio.parentElement.classList.remove('bg-indigo-600', 'text-white');
                });
                
                // Đánh dấu label được chọn
                if (this.checked) {
                    this.parentElement.classList.add('bg-indigo-600', 'text-white');
                }
            });
        });

        // Mảng lưu trữ các ID ảnh đã đánh dấu để xóa
        let imagesToDelete = [];

        // Đặt ảnh làm ảnh chính
        function setAsPrimary(imageId) {
            // Reset tất cả trạng thái ảnh chính
            document.querySelectorAll('[id^="image-status-"]').forEach(statusEl => {
                statusEl.className = "inline-block px-2 py-1 rounded-full bg-gray-100 text-gray-600";
                statusEl.textContent = "Ảnh phụ";
            });
            
            // Đánh dấu ảnh được chọn là ảnh chính
            const statusEl = document.getElementById(`image-status-${imageId}`);
            statusEl.className = "inline-block px-2 py-1 rounded-full bg-green-100 text-green-800";
            statusEl.textContent = "Ảnh chính";
            
            // Cập nhật radio button
            document.getElementById(`primary_image_${imageId}`).checked = true;
        }

        // Đánh dấu ảnh để xóa
        function markForDeletion(imageId) {
            const container = document.getElementById(`image-container-${imageId}`);
            const deleteCheckbox = document.getElementById(`delete_image_${imageId}`);
            
            // Kiểm tra xem ảnh đã được đánh dấu xóa chưa
            if (imagesToDelete.includes(imageId)) {
                // Hủy đánh dấu xóa
                imagesToDelete = imagesToDelete.filter(id => id !== imageId);
                container.classList.remove('opacity-50');
                deleteCheckbox.checked = false;
            } else {
                // Đánh dấu xóa
                imagesToDelete.push(imageId);
                container.classList.add('opacity-50');
                deleteCheckbox.checked = true;
            }
            
            // Cập nhật hiển thị danh sách ảnh để xóa
            updateDeleteList();
        }

        // Cập nhật danh sách ảnh đã đánh dấu để xóa
        function updateDeleteList() {
            const container = document.getElementById('images-to-delete-container');
            const list = document.getElementById('images-to-delete-list');
            
            if (imagesToDelete.length > 0) {
                container.classList.remove('hidden');
                list.innerHTML = '';
                imagesToDelete.forEach(id => {
                    const item = document.createElement('li');
                    item.innerHTML = `Ảnh #${id} <button type="button" onclick="markForDeletion(${id})" class="text-xs text-red-700 underline ml-2">Hủy</button>`;
                    list.appendChild(item);
                });
            } else {
                container.classList.add('hidden');
            }
        }

        // Hủy tất cả các đánh dấu xóa
        function clearAllDeletions() {
            // Xóa lớp opacity từ tất cả các container
            imagesToDelete.forEach(id => {
                const container = document.getElementById(`image-container-${id}`);
                if (container) container.classList.remove('opacity-50');
                
                const checkbox = document.getElementById(`delete_image_${id}`);
                if (checkbox) checkbox.checked = false;
            });
            
            // Xóa mảng
            imagesToDelete = [];
            
            // Cập nhật hiển thị
            updateDeleteList();
        }
    </script>
@endsection 