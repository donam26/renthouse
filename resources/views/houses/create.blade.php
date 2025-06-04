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

                    <!-- Hiển thị tổng quan các lỗi validation -->
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

                    <!-- Thông tin vị trí -->
                    <div class="text-lg font-medium text-gray-900 mb-4">Thông tin vị trí</div>
                    
                    <!-- Chọn loại vị trí -->
                    <div class="mb-6">
                        <x-input-label for="location_type" :value="__('Chọn loại vị trí')" class="text-base font-semibold mb-3" />
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <label class="flex flex-col items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors location-option"
                                   onclick="toggleLocationType('ga_chinh')">
                                <input type="radio" name="location_type" value="ga_chinh" class="hidden" {{ old('location_type') == 'ga_chinh' ? 'checked' : '' }}>
                                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mb-2">
                                    <i class="fas fa-subway text-indigo-600 text-xl"></i>
                                </div>
                                <span class="font-medium text-gray-800">Ga chính</span>
                                <div class="w-full h-1 mt-2 location-indicator {{ old('location_type') == 'ga_chinh' ? 'bg-indigo-600' : 'bg-transparent' }}"></div>
                            </label>
                            
                            <label class="flex flex-col items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors location-option"
                                   onclick="toggleLocationType('ga_ben_canh')">
                                <input type="radio" name="location_type" value="ga_ben_canh" class="hidden" {{ old('location_type') == 'ga_ben_canh' ? 'checked' : '' }}>
                                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mb-2">
                                    <i class="fas fa-train text-green-600 text-xl"></i>
                                </div>
                                <span class="font-medium text-gray-800">Ga bên cạnh</span>
                                <div class="w-full h-1 mt-2 location-indicator {{ old('location_type') == 'ga_ben_canh' ? 'bg-indigo-600' : 'bg-transparent' }}"></div>
                            </label>
                            
                            <label class="flex flex-col items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors location-option"
                                   onclick="toggleLocationType('ga_di_tau_toi')">
                                <input type="radio" name="location_type" value="ga_di_tau_toi" class="hidden" {{ old('location_type') == 'ga_di_tau_toi' ? 'checked' : '' }}>
                                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mb-2">
                                    <i class="fas fa-route text-blue-600 text-xl"></i>
                                </div>
                                <span class="font-medium text-gray-800">Ga đi tàu tới</span>
                                <div class="w-full h-1 mt-2 location-indicator {{ old('location_type') == 'ga_di_tau_toi' ? 'bg-indigo-600' : 'bg-transparent' }}"></div>
                            </label>
                            
                            <label class="flex flex-col items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors location-option"
                                   onclick="toggleLocationType('company')">
                                <input type="radio" name="location_type" value="company" class="hidden" {{ old('location_type') == 'company' ? 'checked' : '' }}>
                                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mb-2">
                                    <i class="fas fa-building text-red-600 text-xl"></i>
                                </div>
                                <span class="font-medium text-gray-800">Công ty</span>
                                <div class="w-full h-1 mt-2 location-indicator {{ old('location_type') == 'company' ? 'bg-indigo-600' : 'bg-transparent' }}"></div>
                            </label>
                        </div>
                        
                        @error('location_type')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Thông tin chi tiết vị trí -->
                    <div id="location_details" class="mb-6 p-5 border rounded-lg bg-gray-50">
                        <!-- Ga chính -->
                        <div id="ga_chinh_section" class="location-section {{ old('location_type') == 'ga_chinh' ? '' : 'hidden' }}">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="col-span-2">
                                    <x-input-label for="ga_chinh" :value="__('Tên ga chính')" class="mb-1" />
                                    <x-text-input id="ga_chinh" class="block w-full" type="text" name="ga_chinh" :value="old('ga_chinh')" placeholder="Nhập tên ga chính" />
                                    <x-input-error :messages="$errors->get('ga_chinh')" class="mt-1" />
                                </div>
                                <div>
                                    <x-input-label for="ga_chinh_house_type" :value="__('Loại nhà')" class="mb-1" />
                                    <select id="ga_chinh_house_type" name="ga_chinh_house_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                                        <option value="1R-1K" {{ old('ga_chinh_house_type') == '1R-1K' ? 'selected' : '' }}>1R-1K</option>
                                        <option value="2K-2DK" {{ old('ga_chinh_house_type') == '2K-2DK' ? 'selected' : '' }}>2K-2DK</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('ga_chinh_house_type')" class="mt-1" />
                                </div>
                            </div>
                        </div>
                        
                        <!-- Ga bên cạnh -->
                        <div id="ga_ben_canh_section" class="location-section {{ old('location_type') == 'ga_ben_canh' ? '' : 'hidden' }}">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="col-span-2">
                                    <x-input-label for="ga_ben_canh" :value="__('Tên ga bên cạnh')" class="mb-1" />
                                    <x-text-input id="ga_ben_canh" class="block w-full" type="text" name="ga_ben_canh" :value="old('ga_ben_canh')" placeholder="Nhập tên ga bên cạnh" />
                                    <x-input-error :messages="$errors->get('ga_ben_canh')" class="mt-1" />
                                </div>
                                <div>
                                    <x-input-label for="ga_ben_canh_house_type" :value="__('Loại nhà')" class="mb-1" />
                                    <select id="ga_ben_canh_house_type" name="ga_ben_canh_house_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                                        <option value="1R-1K" {{ old('ga_ben_canh_house_type') == '1R-1K' ? 'selected' : '' }}>1R-1K</option>
                                        <option value="2K-2DK" {{ old('ga_ben_canh_house_type') == '2K-2DK' ? 'selected' : '' }}>2K-2DK</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('ga_ben_canh_house_type')" class="mt-1" />
                                </div>
                            </div>
                        </div>
                        
                        <!-- Ga đi tàu tới -->
                        <div id="ga_di_tau_toi_section" class="location-section {{ old('location_type') == 'ga_di_tau_toi' ? '' : 'hidden' }}">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="col-span-2">
                                    <x-input-label for="ga_di_tau_toi" :value="__('Tên ga đi tàu tới')" class="mb-1" />
                                    <x-text-input id="ga_di_tau_toi" class="block w-full" type="text" name="ga_di_tau_toi" :value="old('ga_di_tau_toi')" placeholder="Nhập tên ga đi tàu tới" />
                                    <x-input-error :messages="$errors->get('ga_di_tau_toi')" class="mt-1" />
                                </div>
                                <div>
                                    <x-input-label for="ga_di_tau_toi_house_type" :value="__('Loại nhà')" class="mb-1" />
                                    <select id="ga_di_tau_toi_house_type" name="ga_di_tau_toi_house_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                                        <option value="1R-1K" {{ old('ga_di_tau_toi_house_type') == '1R-1K' ? 'selected' : '' }}>1R-1K</option>
                                        <option value="2K-2DK" {{ old('ga_di_tau_toi_house_type') == '2K-2DK' ? 'selected' : '' }}>2K-2DK</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('ga_di_tau_toi_house_type')" class="mt-1" />
                                </div>
                            </div>
                        </div>
                        
                        <!-- Công ty -->
                        <div id="company_section" class="location-section {{ old('location_type') == 'company' ? '' : 'hidden' }}">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="col-span-2">
                                    <input id="is_company" type="hidden" name="is_company" value="1">
                                </div>
                                <div>
                                    <x-input-label for="company_house_type" :value="__('Loại nhà')" class="mb-1" />
                                    <select id="company_house_type" name="company_house_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                                        <option value="1R-1K" {{ old('company_house_type') == '1R-1K' ? 'selected' : '' }}>1R-1K</option>
                                        <option value="2K-2DK" {{ old('company_house_type') == '2K-2DK' ? 'selected' : '' }}>2K-2DK</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('company_house_type')" class="mt-1" />
                                </div>
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
                        <!-- Khoảng cách đến ga -->
                        <div class="mb-4">
                            <x-input-label for="distance" :value="__('Khoảng cách đến ga (phút đi bộ)')" />
                            <x-text-input id="distance" class="block mt-1 w-full" type="number" name="distance" :value="old('distance')" min="0" />
                            <x-input-error :messages="$errors->get('distance')" class="mt-2" />
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
                        <!-- Giá tiền -->
                        <div class="mb-4">
                            <x-input-label for="rent_price" :value="__('Giá tiền (yên/tháng)')" />
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

@push('scripts')
<script>
    function toggleLocationType(type) {
        // Ẩn tất cả các section
        document.querySelectorAll('.location-section').forEach(section => {
            section.classList.add('hidden');
        });
        
        // Hiển thị section được chọn
        document.getElementById(type + '_section').classList.remove('hidden');
        
        // Cập nhật style cho các option
        document.querySelectorAll('.location-option').forEach(option => {
            option.querySelector('.location-indicator').classList.replace('bg-indigo-600', 'bg-transparent');
        });
        
        // Highlight option được chọn
        const selectedOption = document.querySelector('input[name="location_type"][value="' + type + '"]').closest('.location-option');
        selectedOption.querySelector('.location-indicator').classList.replace('bg-transparent', 'bg-indigo-600');
        
        // Xử lý trường hợp is_company
        const isCompanyField = document.getElementById('is_company');
        if (type === 'company') {
            // Nếu chọn tab công ty, đảm bảo trường is_company có giá trị 1
            isCompanyField.value = '1';
        } else {
            // Nếu chọn tab khác, đặt giá trị is_company thành rỗng để không gửi khi submit form
            isCompanyField.value = '';
        }
    }
    
    // Thiết lập giá trị ban đầu dựa vào radio đã chọn
    document.addEventListener('DOMContentLoaded', function() {
        const selectedType = document.querySelector('input[name="location_type"]:checked');
        if (selectedType) {
            toggleLocationType(selectedType.value);
        } else {
            // Nếu chưa có lựa chọn, mặc định chọn ga_chinh
            document.querySelector('input[name="location_type"][value="ga_chinh"]').checked = true;
            toggleLocationType('ga_chinh');
        }
        
        // Thêm sự kiện cho tất cả các radio button
        document.querySelectorAll('input[name="location_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                toggleLocationType(this.value);
            });
        });
    });
    
    // Preview ảnh đã tồn tại
    document.getElementById('image').addEventListener('change', function(event) {
        const preview = document.getElementById('image-preview');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.querySelector('img').src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('hidden');
        }
    });
    
    // Preview ảnh bổ sung
    document.getElementById('additional_images').addEventListener('change', function(event) {
        const preview = document.getElementById('additional-images-preview');
        preview.innerHTML = '';
        
        const files = event.target.files;
        if (files.length > 0) {
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgContainer = document.createElement('div');
                    imgContainer.className = 'relative h-32 rounded-lg overflow-hidden border border-gray-300';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-full object-cover';
                    
                    imgContainer.appendChild(img);
                    preview.appendChild(imgContainer);
                };
                reader.readAsDataURL(file);
            });
        }
    });
</script>
@endpush 