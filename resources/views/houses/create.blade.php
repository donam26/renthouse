@extends('layouts.main')

@section('title', 'Thêm nhà mới')

@section('header')
    <div class="flex items-center">
        <i class="fas fa-plus-circle text-3xl mr-3"></i>
        <h1 class="text-2xl md:text-3xl font-bold">Thêm nhà cho thuê mới</h1>
    </div>
@endsection

@section('content')
    <div class="card p-6 md:p-8">
        <div class="border-b border-gray-200 pb-4 mb-6">
            <h2 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-clipboard-list text-indigo-500 mr-2"></i>
                Thông tin nhà cho thuê
            </h2>
            <p class="text-sm text-gray-500 mt-1">Vui lòng điền đầy đủ các thông tin cần thiết</p>
        </div>
        
        <form action="{{ route('houses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Cột bên trái -->
                <div class="space-y-6">
                    <div class="mb-6">
                        <h3 class="text-md font-semibold text-gray-700 mb-4 flex items-center">
                            <i class="fas fa-info-circle text-indigo-500 mr-2"></i>
                            Thông tin cơ bản
                        </h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên nhà <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-30 transition"
                                    placeholder="Nhập tên nhà" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ <span class="text-red-500">*</span></label>
                                <input type="text" name="address" id="address" value="{{ old('address') }}" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-30 transition"
                                    placeholder="Nhập địa chỉ đầy đủ" required>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Vị trí</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    </div>
                                    <input type="text" name="location" id="location" value="{{ old('location') }}"
                                        class="w-full rounded-md border-gray-300 pl-10 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-30 transition"
                                        placeholder="Vị trí (ví dụ: Tokyo, OSAKA, etc.)">
                                </div>
                                @error('location')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="distance" class="block text-sm font-medium text-gray-700 mb-1">Khoảng cách (m)</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-ruler text-gray-400"></i>
                                        </div>
                                        <input type="number" step="0.01" min="0" name="distance" id="distance" value="{{ old('distance') }}"
                                            class="w-full rounded-md border-gray-300 pl-10 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-30 transition"
                                            placeholder="Nhập khoảng cách">
                                    </div>
                                    @error('distance')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="transportation" class="block text-sm font-medium text-gray-700 mb-1">Phương tiện</label>
                                    <select name="transportation" id="transportation" 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-30 transition">
                                        <option value="">-- Chọn phương tiện --</option>
                                        <option value="Xe đạp" {{ old('transportation') === 'Xe đạp' ? 'selected' : '' }}>Xe đạp</option>
                                        <option value="Tàu" {{ old('transportation') === 'Tàu' ? 'selected' : '' }}>Tàu</option>
                                        <option value="Xe buýt" {{ old('transportation') === 'Xe buýt' ? 'selected' : '' }}>Xe buýt</option>
                                        <option value="Đi bộ" {{ old('transportation') === 'Đi bộ' ? 'selected' : '' }}>Đi bộ</option>
                                    </select>
                                    @error('transportation')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-md font-semibold text-gray-700 mb-4 flex items-center">
                            <i class="fas fa-dollar-sign text-indigo-500 mr-2"></i>
                            Thông tin giá cả
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="rent_price" class="block text-sm font-medium text-gray-700 mb-1">Giá thuê (VND) <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-tag text-gray-400"></i>
                                        </div>
                                        <input type="number" name="rent_price" id="rent_price" value="{{ old('rent_price') }}"
                                            class="w-full rounded-md border-gray-300 pl-10 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-30 transition"
                                            placeholder="Nhập giá thuê" required>
                                    </div>
                                    @error('rent_price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="deposit_price" class="block text-sm font-medium text-gray-700 mb-1">Giá đặt cọc (VND)</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-money-bill-wave text-gray-400"></i>
                                        </div>
                                        <input type="number" name="deposit_price" id="deposit_price" value="{{ old('deposit_price') }}"
                                            class="w-full rounded-md border-gray-300 pl-10 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-30 transition"
                                            placeholder="Nhập giá đặt cọc">
                                    </div>
                                    @error('deposit_price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Cột bên phải -->
                <div class="space-y-6">
                    <div class="mb-6">
                        <h3 class="text-md font-semibold text-gray-700 mb-4 flex items-center">
                            <i class="fas fa-home text-indigo-500 mr-2"></i>
                            Thông tin nhà
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="house_type" class="block text-sm font-medium text-gray-700 mb-1">Dạng nhà</label>
                                    <select name="house_type" id="house_type" 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-30 transition">
                                        <option value="">-- Chọn loại nhà --</option>
                                        <option value="1r" {{ old('house_type') === '1r' ? 'selected' : '' }}>1r</option>
                                        <option value="1k" {{ old('house_type') === '1k' ? 'selected' : '' }}>1k</option>
                                        <option value="1DK" {{ old('house_type') === '1DK' ? 'selected' : '' }}>1DK</option>
                                        <option value="2K" {{ old('house_type') === '2K' ? 'selected' : '' }}>2K</option>
                                        <option value="2DK" {{ old('house_type') === '2DK' ? 'selected' : '' }}>2DK</option>
                                        <option value="3DK" {{ old('house_type') === '3DK' ? 'selected' : '' }}>3DK</option>
                                    </select>
                                    @error('house_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Tình trạng <span class="text-red-500">*</span></label>
                                    <select name="status" id="status" 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-30 transition" required>
                                        <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Còn trống</option>
                                        <option value="rented" {{ old('status') === 'rented' ? 'selected' : '' }}>Đã thuê</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                                <textarea name="description" id="description" rows="4"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-30 transition"
                                    placeholder="Nhập mô tả chi tiết về nhà cho thuê">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="share_link" class="block text-sm font-medium text-gray-700 mb-1">Đường dẫn chia sẻ</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-link text-gray-400"></i>
                                    </div>
                                    <input type="text" name="share_link" id="share_link" value="{{ old('share_link') }}"
                                        class="w-full rounded-md border-gray-300 pl-10 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-30 transition"
                                        placeholder="URL liên kết chia sẻ">
                                </div>
                                @error('share_link')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Ảnh -->
                            <div class="mb-6">
                                <h3 class="text-md font-semibold text-gray-700 mb-4 flex items-center">
                                    <i class="fas fa-images text-indigo-500 mr-2"></i>
                                    Hình ảnh
                                </h3>
                                
                                <div class="space-y-4">
                                    <!-- Ảnh chính -->
                                    <div>
                                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Ảnh chính</label>
                                        <input type="file" name="image" id="image" accept="image/*" 
                                            class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer transition-colors">
                                        <p class="mt-1 text-xs text-gray-500">PNG, JPG hoặc GIF (tối đa 2MB)</p>
                                        @error('image')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <!-- Ảnh bổ sung -->
                                    <div>
                                        <label for="additional_images" class="block text-sm font-medium text-gray-700 mb-1">Ảnh bổ sung</label>
                                        <input type="file" name="additional_images[]" id="additional_images" accept="image/*" multiple
                                            class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer transition-colors">
                                        <p class="mt-1 text-xs text-gray-500">Chọn nhiều ảnh cùng lúc. PNG, JPG hoặc GIF (tối đa 2MB mỗi ảnh)</p>
                                        @error('additional_images.*')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <!-- Hiển thị xem trước ảnh -->
                                    <div class="mt-2" id="image-preview-container">
                                        <p class="text-sm font-medium text-gray-700 mb-2">Xem trước ảnh:</p>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="image-preview">
                                            <!-- JavaScript sẽ thêm các xem trước ảnh vào đây -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="pt-5 border-t border-gray-200">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('houses.index') }}" class="btn-secondary inline-flex items-center">
                        <i class="fas fa-times mr-2"></i> Hủy bỏ
                    </a>
                    <button type="submit" class="btn-primary inline-flex items-center">
                        <i class="fas fa-save mr-2"></i> Lưu nhà
                    </button>
                </div>
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
        
        // Xử lý xem trước ảnh
        document.addEventListener('DOMContentLoaded', function() {
            const mainImageInput = document.getElementById('image');
            const additionalImagesInput = document.getElementById('additional_images');
            const previewContainer = document.getElementById('image-preview');
            
            // Xem trước ảnh chính
            mainImageInput.addEventListener('change', function() {
                previewContainer.innerHTML = ''; // Xóa các xem trước cũ
                
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const previewDiv = document.createElement('div');
                        previewDiv.className = 'relative';
                        
                        previewDiv.innerHTML = `
                            <div class="h-40 rounded-lg overflow-hidden shadow-md">
                                <img src="${e.target.result}" class="w-full h-full object-cover">
                            </div>
                            <div class="mt-1 text-xs text-center">
                                <span class="inline-block px-2 py-1 bg-green-100 text-green-800 rounded-full">Ảnh chính</span>
                            </div>
                        `;
                        
                        previewContainer.appendChild(previewDiv);
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });
            
            // Xem trước ảnh bổ sung
            additionalImagesInput.addEventListener('change', function() {
                // Giữ lại ảnh chính nếu có
                const mainImagePreview = previewContainer.querySelector('.inline-block.px-2.py-1.bg-green-100');
                if (!mainImagePreview) {
                    previewContainer.innerHTML = '';
                }
                
                if (this.files) {
                    Array.from(this.files).forEach((file, index) => {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            const previewDiv = document.createElement('div');
                            previewDiv.className = 'relative';
                            
                            previewDiv.innerHTML = `
                                <div class="h-40 rounded-lg overflow-hidden shadow-md">
                                    <img src="${e.target.result}" class="w-full h-full object-cover">
                                </div>
                                <div class="mt-1 text-xs text-center">
                                    <span class="inline-block px-2 py-1 bg-gray-100 text-gray-600 rounded-full">Ảnh phụ ${index + 1}</span>
                                </div>
                            `;
                            
                            previewContainer.appendChild(previewDiv);
                        }
                        
                        reader.readAsDataURL(file);
                    });
                }
            });
        });
    </script>
@endsection 