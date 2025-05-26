@extends('layouts.main')

@section('title', 'Chỉnh sửa nhà cho thuê - ' . $house->name)

@section('header')
    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold">Chỉnh sửa nhà cho thuê</h1>
            <p class="text-gray-100 mt-1">Cập nhật thông tin cho "{{ $house->name }}"</p>
        </div>
        <div>
            <a href="{{ route('houses.index') }}" class="btn-secondary inline-flex items-center">
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

                    <!-- Khoảng cách -->
                    <div class="mb-4">
                        <label for="distance" class="block mb-2 text-sm font-medium text-gray-700">Khoảng cách (mét)</label>
                        <input type="number" step="0.01" id="distance" name="distance" value="{{ old('distance', $house->distance) }}"
                            class="input-field @error('distance') border-red-500 @enderror">
                        @error('distance')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phương tiện đi lại -->
                    <div class="mb-4">
                        <label for="transportation" class="block mb-2 text-sm font-medium text-gray-700">Phương tiện đi lại</label>
                        <select id="transportation" name="transportation" class="input-field @error('transportation') border-red-500 @enderror">
                            <option value="">-- Chọn phương tiện --</option>
                            <option value="Đi bộ" {{ old('transportation', $house->transportation) == 'Đi bộ' ? 'selected' : '' }}>Đi bộ</option>
                            <option value="Xe đạp" {{ old('transportation', $house->transportation) == 'Xe đạp' ? 'selected' : '' }}>Xe đạp</option>
                            <option value="Tàu" {{ old('transportation', $house->transportation) == 'Tàu' ? 'selected' : '' }}>Tàu</option>
                        </select>
                        @error('transportation')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Cột thông tin khác -->
                <div>
                    <h2 class="text-xl font-bold mb-4 text-gray-800">Thông tin khác</h2>

                    <!-- Giá thuê -->
                    <div class="mb-4">
                        <label for="rent_price" class="block mb-2 text-sm font-medium text-gray-700">Giá thuê (VND) <span class="text-red-500">*</span></label>
                        <div class="flex items-center">
                            <span class="bg-gray-100 px-3 py-3 border border-gray-300 border-r-0 rounded-l-md text-gray-700">VND</span>
                            <input type="number" id="rent_price" name="rent_price" value="{{ old('rent_price', $house->rent_price) }}" required
                                class="input-field rounded-l-none @error('rent_price') border-red-500 @enderror">
                        </div>
                        @error('rent_price')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Giá đặt cọc -->
                    <div class="mb-4">
                        <label for="deposit_price" class="block mb-2 text-sm font-medium text-gray-700">Giá đặt cọc (VND)</label>
                        <div class="flex items-center">
                            <span class="bg-gray-100 px-3 py-3 border border-gray-300 border-r-0 rounded-l-md text-gray-700">VND</span>
                            <input type="number" id="deposit_price" name="deposit_price" value="{{ old('deposit_price', $house->deposit_price) }}"
                                class="input-field rounded-l-none @error('deposit_price') border-red-500 @enderror">
                        </div>
                        @error('deposit_price')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Dạng nhà -->
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Dạng nhà</label>
                        <div class="grid grid-cols-5 gap-2">
                            @foreach(['1r', '1k', '1DK', '2K', '2DK', '3DK'] as $type)
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
            
            <!-- Ảnh nhà -->
            <div class="mb-6">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Ảnh nhà</h2>
                
                <!-- Ảnh chính hiện tại và các ảnh bổ sung -->
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-700 mb-2">Ảnh hiện tại:</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @if ($images->count() > 0)
                            @foreach($images as $image)
                                <div class="relative group">
                                    <div class="w-full h-40 rounded-lg overflow-hidden">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Ảnh nhà" class="w-full h-full object-cover">
                                    </div>
                                    <div class="absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center space-x-2">
                                        <label class="inline-flex items-center p-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 cursor-pointer">
                                            <input type="radio" name="primary_image_id" value="{{ $image->id }}" {{ $image->is_primary ? 'checked' : '' }} class="hidden">
                                            <i class="fas fa-star"></i>
                                        </label>
                                        <label class="inline-flex items-center p-2 bg-red-600 text-white rounded-full hover:bg-red-700 cursor-pointer">
                                            <input type="checkbox" name="images_to_delete[]" value="{{ $image->id }}" class="hidden">
                                            <i class="fas fa-trash"></i>
                                        </label>
                                    </div>
                                    <div class="mt-1 text-xs text-center">
                                        @if($image->is_primary)
                                            <span class="inline-block px-2 py-1 bg-green-100 text-green-800 rounded-full">Ảnh chính</span>
                                        @else
                                            <span class="inline-block px-2 py-1 bg-gray-100 text-gray-600 rounded-full">Ảnh phụ</span>
                                        @endif
                                    </div>
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
            </div>

            <!-- Nút lưu -->
            <div class="border-t border-gray-200 pt-6 flex justify-end space-x-2">
                <a href="{{ route('houses.show', $house) }}" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Quay lại chi tiết
                </a>
                <a href="{{ route('houses.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md shadow-md hover:bg-gray-700 transition">
                    <i class="fas fa-list mr-2"></i> Danh sách nhà
                </a>
                <button type="submit" name="save_and_continue" value="1" class="btn-primary flex items-center">
                    <i class="fas fa-save mr-2"></i> Lưu và tiếp tục
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
    </script>
@endsection 