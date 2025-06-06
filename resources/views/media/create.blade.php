<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Thêm Media mới') }}
            </h2>
            <a href="{{ route('media.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('media.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Thông báo lỗi -->
                        @if ($errors->any())
                            <div class="mb-4 bg-red-50 p-4 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">
                                            Có {{ $errors->count() }} lỗi cần sửa:
                                        </h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <ul class="list-disc pl-5 space-y-1">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Loại media -->
                        <div class="mb-6">
                            <label for="media_type" class="block text-sm font-medium text-gray-700">Loại media <span class="text-red-600">*</span></label>
                            <select id="media_type" name="media_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="" disabled selected>-- Chọn loại media --</option>
                                <option value="video" {{ old('media_type') == 'video' ? 'selected' : '' }}>Video</option>
                                <option value="license" {{ old('media_type') == 'license' ? 'selected' : '' }}>Giấy phép</option>
                                <option value="interaction" {{ old('media_type') == 'interaction' ? 'selected' : '' }}>Ảnh tương tác</option>
                            </select>
                        </div>
                        
                        <!-- Tiêu đề -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700">Tiêu đề</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="mt-1 text-sm text-gray-500">Tiêu đề mô tả ngắn gọn về nội dung media.</p>
                        </div>
                        
                        <!-- Mô tả -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Mô tả</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Mô tả chi tiết về nội dung media.</p>
                        </div>
                        
                        <!-- File upload -->
                        <div class="mb-6">
                            <label for="file" class="block text-sm font-medium text-gray-700">Tệp tin <span class="text-red-600">*</span></label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md" id="drop-area">
                                <div class="space-y-1 text-center">
                                    <div id="preview-container" class="hidden mb-4">
                                        <img id="image-preview" class="max-h-48 mx-auto hidden">
                                        <video id="video-preview" class="max-h-48 mx-auto hidden" controls></video>
                                    </div>
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Tải lên tệp tin</span>
                                            <input id="file" name="file" type="file" class="sr-only" accept="image/*, video/*" required>
                                        </label>
                                        <p class="pl-1">hoặc kéo thả vào đây</p>
                                    </div>
                                    <p class="text-xs text-gray-500" id="file-type-hint">
                                        PNG, JPG, GIF tối đa 5MB
                                    </p>
                                    <p class="text-xs text-gray-500 mt-2" id="selected-filename"></p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Trạng thái -->
                        <div class="mb-6">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                    Hiển thị trên trang chia sẻ
                                </label>
                            </div>
                        </div>
                        
                        <!-- Nút submit -->
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-save mr-2"></i> Lưu media
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mediaTypeSelect = document.getElementById('media_type');
            const fileTypeHint = document.getElementById('file-type-hint');
            const fileInput = document.getElementById('file');
            const selectedFilename = document.getElementById('selected-filename');
            const imagePreview = document.getElementById('image-preview');
            const videoPreview = document.getElementById('video-preview');
            const previewContainer = document.getElementById('preview-container');
            const dropArea = document.getElementById('drop-area');
            
            // Cập nhật hint khi thay đổi loại media
            mediaTypeSelect.addEventListener('change', function() {
                updateFileTypeHint(this.value);
            });
            
            // Hàm cập nhật hint
            function updateFileTypeHint(mediaType) {
                if (mediaType === 'video') {
                    fileTypeHint.textContent = 'MP4, MOV, AVI, WMV tối đa 20MB';
                    fileInput.accept = 'video/*';
                } else {
                    fileTypeHint.textContent = 'PNG, JPG, GIF tối đa 5MB';
                    fileInput.accept = 'image/*';
                }
            }
            
            // Xử lý khi chọn file
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    selectedFilename.textContent = `Đã chọn: ${file.name} (${formatFileSize(file.size)})`;
                    
                    // Hiển thị preview
                    showPreview(file);
                }
            });
            
            // Hàm hiển thị preview
            function showPreview(file) {
                const fileType = file.type;
                
                // Reset previews
                imagePreview.classList.add('hidden');
                videoPreview.classList.add('hidden');
                
                if (fileType.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                        previewContainer.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                } else if (fileType.startsWith('video/')) {
                    const url = URL.createObjectURL(file);
                    videoPreview.src = url;
                    videoPreview.classList.remove('hidden');
                    previewContainer.classList.remove('hidden');
                }
            }
            
            // Hàm format kích thước file
            function formatFileSize(bytes) {
                if (bytes < 1024) return bytes + ' bytes';
                else if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
                else return (bytes / 1048576).toFixed(1) + ' MB';
            }
            
            // Xử lý kéo thả file
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                dropArea.classList.add('border-indigo-300', 'bg-indigo-50');
            }
            
            function unhighlight() {
                dropArea.classList.remove('border-indigo-300', 'bg-indigo-50');
            }
            
            dropArea.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files.length > 0) {
                    fileInput.files = files;
                    const file = files[0];
                    selectedFilename.textContent = `Đã chọn: ${file.name} (${formatFileSize(file.size)})`;
                    showPreview(file);
                }
            }
            
            // Cập nhật hint ban đầu nếu đã có giá trị
            if (mediaTypeSelect.value) {
                updateFileTypeHint(mediaTypeSelect.value);
            }
        });
    </script>
    @endpush
</x-app-layout> 