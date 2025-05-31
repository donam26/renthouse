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

            <!-- Thông tin ga tàu -->
            <div class="mb-6">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Thông tin ga tàu</h2>
                
                <!-- Ga chính -->
                <div class="mb-6 border-b pb-4">
                    <div class="flex items-center justify-between mb-2">
                        <label for="ga_chinh" class="block text-sm font-medium text-gray-700">Ga chính</label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="col-span-2">
                            <input type="text" id="ga_chinh" name="ga_chinh" value="{{ old('ga_chinh', $house->ga_chinh) }}"
                                class="input-field @error('ga_chinh') border-red-500 @enderror" placeholder="Nhập tên ga chính">
                            @error('ga_chinh')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <select id="ga_chinh_house_type" name="ga_chinh_house_type" 
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full @error('ga_chinh_house_type') border-red-500 @enderror">
                                <option value="1R-1K" {{ old('ga_chinh_house_type', $house->ga_chinh_house_type) == '1R-1K' ? 'selected' : '' }}>1R-1K</option>
                                <option value="2K-2DK" {{ old('ga_chinh_house_type', $house->ga_chinh_house_type) == '2K-2DK' ? 'selected' : '' }}>2K-2DK</option>
                            </select>
                            @error('ga_chinh_house_type')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Ga bên cạnh -->
                <div class="mb-6 border-b pb-4">
                    <div class="flex items-center justify-between mb-2">
                        <label for="ga_ben_canh" class="block text-sm font-medium text-gray-700">Ga bên cạnh</label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="col-span-2">
                            <input type="text" id="ga_ben_canh" name="ga_ben_canh" value="{{ old('ga_ben_canh', $house->ga_ben_canh) }}"
                                class="input-field @error('ga_ben_canh') border-red-500 @enderror" placeholder="Nhập tên ga bên cạnh">
                            @error('ga_ben_canh')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <select id="ga_ben_canh_house_type" name="ga_ben_canh_house_type" 
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full @error('ga_ben_canh_house_type') border-red-500 @enderror">
                                <option value="1R-1K" {{ old('ga_ben_canh_house_type', $house->ga_ben_canh_house_type) == '1R-1K' ? 'selected' : '' }}>1R-1K</option>
                                <option value="2K-2DK" {{ old('ga_ben_canh_house_type', $house->ga_ben_canh_house_type) == '2K-2DK' ? 'selected' : '' }}>2K-2DK</option>
                            </select>
                            @error('ga_ben_canh_house_type')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Ga đi tàu tới -->
                <div class="mb-6 border-b pb-4">
                    <div class="flex items-center justify-between mb-2">
                        <label for="ga_di_tau_toi" class="block text-sm font-medium text-gray-700">Ga đi tàu tới</label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="col-span-2">
                            <input type="text" id="ga_di_tau_toi" name="ga_di_tau_toi" value="{{ old('ga_di_tau_toi', $house->ga_di_tau_toi) }}"
                                class="input-field @error('ga_di_tau_toi') border-red-500 @enderror" placeholder="Nhập tên ga đi tàu tới">
                            @error('ga_di_tau_toi')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <select id="ga_di_tau_toi_house_type" name="ga_di_tau_toi_house_type" 
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full @error('ga_di_tau_toi_house_type') border-red-500 @enderror">
                                <option value="1R-1K" {{ old('ga_di_tau_toi_house_type', $house->ga_di_tau_toi_house_type) == '1R-1K' ? 'selected' : '' }}>1R-1K</option>
                                <option value="2K-2DK" {{ old('ga_di_tau_toi_house_type', $house->ga_di_tau_toi_house_type) == '2K-2DK' ? 'selected' : '' }}>2K-2DK</option>
                            </select>
                            @error('ga_di_tau_toi_house_type')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Là công ty -->
                <div class="mb-6 border-b pb-4">
                    <div class="flex items-center justify-between mb-2">
                        <label for="is_company" class="block text-sm font-medium text-gray-700">Là công ty</label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="col-span-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" id="is_company" name="is_company" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    {{ old('is_company', $house->is_company) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Nhà này thuộc công ty</span>
                            </label>
                            @error('is_company')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <select id="company_house_type" name="company_house_type" 
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full @error('company_house_type') border-red-500 @enderror">
                                <option value="1R-1K" {{ old('company_house_type', $house->company_house_type) == '1R-1K' ? 'selected' : '' }}>1R-1K</option>
                                <option value="2K-2DK" {{ old('company_house_type', $house->company_house_type) == '2K-2DK' ? 'selected' : '' }}>2K-2DK</option>
                            </select>
                            @error('company_house_type')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Mô tả chi tiết -->
                <div class="mt-4">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-700">Mô tả chi tiết</label>
                    <textarea id="description" name="description" rows="4" 
                        class="input-field @error('description') border-red-500 @enderror"
                        placeholder="Nhập mô tả chi tiết về nhà cho thuê...">{{ old('description', $house->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                    <!-- Giá đầu vào -->
                    <div class="mb-4">
                        <label for="input_price" class="block mb-2 text-sm font-medium text-gray-700">Tiền đầu vào (yên)</label>
                        <div class="flex items-center">
                            <span class="bg-gray-100 px-3 py-3 border border-gray-300 border-r-0 rounded-l-md text-gray-700">¥</span>
                            <input type="number" id="input_price" name="input_price" value="{{ old('input_price', $house->input_price) }}"
                                class="input-field rounded-l-none @error('input_price') border-red-500 @enderror">
                        </div>
                        @error('input_price')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Loại nhà mặc định -->
                    <div class="mb-4">
                        <x-input-label for="default_house_type" :value="__('Loại nhà mặc định')" />
                        <div class="mt-2 grid grid-cols-2 gap-3">
                            @foreach(['1R-1K', '2K-2DK'] as $type)
                            <label class="flex items-center justify-center p-2 border border-gray-300 rounded-md {{ old('default_house_type', $house->default_house_type) == $type ? 'bg-indigo-600 text-white' : '' }} hover:bg-indigo-100 cursor-pointer transition-colors">
                                <input type="radio" name="default_house_type" value="{{ $type }}" class="hidden house-type-input"
                                    {{ old('default_house_type', $house->default_house_type) == $type ? 'checked' : '' }}>
                                {{ $type }}
                            </label>
                            @endforeach
                        </div>
                        @error('default_house_type')
                            <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
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
                                                onclick="setAsPrimary('{{ $image->id }}')" title="Đặt làm ảnh chính">
                                            <i class="fas fa-star"></i>
                                        </button>
                                        <button type="button" class="p-2 bg-red-600 text-white rounded-full hover:bg-red-700 cursor-pointer" 
                                                onclick="markForDeletion('{{ $image->id }}')" title="Đánh dấu xóa">
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
                    item.innerHTML = `Ảnh #${id} <button type="button" onclick="markForDeletion('${id}')" class="text-xs text-red-700 underline ml-2">Hủy</button>`;
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