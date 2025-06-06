<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Quản lý Media') }}
            </h2>
            <a href="{{ route('media.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="fas fa-plus mr-2"></i> Thêm mới
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                    <p class="font-bold">Thành công!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Filter Tabs -->
            <div class="mb-6 bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-2 flex flex-wrap border-b">
                    <a href="{{ route('media.index', ['type' => 'all']) }}" 
                       class="px-4 py-2 mr-2 {{ $mediaType === 'all' ? 'bg-indigo-100 text-indigo-800 font-semibold rounded-md' : 'text-gray-600 hover:bg-gray-100 rounded-md' }}">
                        Tất cả
                    </a>
                    <a href="{{ route('media.index', ['type' => 'video']) }}" 
                       class="px-4 py-2 mr-2 {{ $mediaType === 'video' ? 'bg-indigo-100 text-indigo-800 font-semibold rounded-md' : 'text-gray-600 hover:bg-gray-100 rounded-md' }}">
                        <i class="fas fa-video mr-1"></i> Video
                    </a>
                    <a href="{{ route('media.index', ['type' => 'license']) }}" 
                       class="px-4 py-2 mr-2 {{ $mediaType === 'license' ? 'bg-indigo-100 text-indigo-800 font-semibold rounded-md' : 'text-gray-600 hover:bg-gray-100 rounded-md' }}">
                        <i class="fas fa-certificate mr-1"></i> Giấy phép
                    </a>
                    <a href="{{ route('media.index', ['type' => 'interaction']) }}" 
                       class="px-4 py-2 {{ $mediaType === 'interaction' ? 'bg-indigo-100 text-indigo-800 font-semibold rounded-md' : 'text-gray-600 hover:bg-gray-100 rounded-md' }}">
                        <i class="fas fa-users mr-1"></i> Tương tác
                    </a>
                </div>
            </div>

            <!-- Media Items -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($media->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" 
                             id="media-container"
                             data-update-order-url="{{ route('media.update-order') }}">
                            @foreach ($media as $item)
                                <div class="bg-white border rounded-lg shadow-sm overflow-hidden media-item" data-id="{{ $item->id }}">
                                    <!-- Media Preview -->
                                    <div class="aspect-video bg-gray-100 relative">
                                        @if ($item->media_type === 'video')
                                            <video class="w-full h-full object-cover" controls>
                                                <source src="{{ asset('storage/' . $item->file_path) }}" type="video/mp4">
                                                Trình duyệt không hỗ trợ video.
                                            </video>
                                        @else
                                            <img src="{{ asset('storage/' . $item->file_path) }}" 
                                                 alt="{{ $item->title }}" 
                                                 class="w-full h-full object-cover">
                                        @endif
                                        
                                        <!-- Media Type Badge -->
                                        <div class="absolute top-2 left-2 px-2 py-1 rounded-md text-xs font-medium 
                                            {{ $item->media_type === 'video' ? 'bg-blue-100 text-blue-800' : 
                                               ($item->media_type === 'license' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800') }}">
                                            @if ($item->media_type === 'video')
                                                <i class="fas fa-video mr-1"></i> Video
                                            @elseif ($item->media_type === 'license')
                                                <i class="fas fa-certificate mr-1"></i> Giấy phép
                                            @else
                                                <i class="fas fa-users mr-1"></i> Tương tác
                                            @endif
                                        </div>
                                        
                                        <!-- Active Status -->
                                        <div class="absolute top-2 right-2">
                                            @if ($item->is_active)
                                                <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                                    <i class="fas fa-check-circle mr-1"></i> Hiển thị
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">
                                                    <i class="fas fa-eye-slash mr-1"></i> Ẩn
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Media Details -->
                                    <div class="p-4">
                                        <h3 class="text-lg font-medium text-gray-900 truncate">
                                            {{ $item->title ?? 'Không có tiêu đề' }}
                                        </h3>
                                        
                                        @if ($item->description)
                                            <p class="mt-1 text-sm text-gray-500 line-clamp-2">
                                                {{ $item->description }}
                                            </p>
                                        @endif
                                        
                                        <div class="mt-4 flex justify-between items-center">
                                            <div class="text-sm text-gray-500">
                                                <i class="fas fa-sort mr-1"></i> Thứ tự: {{ $item->sort_order }}
                                            </div>
                                            
                                            <div class="flex space-x-2">
                                                <a href="{{ route('media.edit', $item) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                <form action="{{ route('media.destroy', $item) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900"
                                                            onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-gray-500 mb-4">
                                <i class="fas fa-photo-video text-5xl"></i>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Chưa có media nào</h3>
                            <p class="mt-1 text-sm text-gray-500">Bắt đầu bằng cách tạo media mới.</p>
                            <div class="mt-6">
                                <a href="{{ route('media.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class="fas fa-plus mr-2"></i> Thêm mới
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="mt-6 p-4 bg-gray-50 rounded-lg shadow-sm">
                <h3 class="text-md font-medium text-gray-700 mb-2">
                    <i class="fas fa-info-circle mr-2 text-indigo-500"></i> Hướng dẫn
                </h3>
                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1 ml-4">
                    <li>
                        <span class="font-medium">Video:</span> 
                        Tải lên tối đa 2 video clip để giới thiệu về bạn hoặc dịch vụ cho thuê nhà.
                    </li>
                    <li>
                        <span class="font-medium">Giấy phép:</span> 
                        Tải lên tối đa 4 hình ảnh giấy phép, chứng chỉ để xây dựng uy tín.
                    </li>
                    <li>
                        <span class="font-medium">Tương tác:</span> 
                        Tải lên nhiều hình ảnh thể hiện quá trình làm việc và tương tác với khách hàng.
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script>
        // Khởi tạo Sortable cho container media
        document.addEventListener('DOMContentLoaded', function() {
            const mediaContainer = document.getElementById('media-container');
            if (mediaContainer) {
                const sortable = new Sortable(mediaContainer, {
                    animation: 150,
                    onEnd: function(evt) {
                        // Cập nhật thứ tự sau khi kéo thả
                        updateMediaOrder();
                    }
                });
            }
            
            // Hàm cập nhật thứ tự
            function updateMediaOrder() {
                const items = document.querySelectorAll('.media-item');
                const updateOrderUrl = mediaContainer.dataset.updateOrderUrl;
                
                const data = Array.from(items).map((item, index) => {
                    return {
                        id: item.dataset.id,
                        order: index
                    };
                });
                
                // Gửi request cập nhật thứ tự
                fetch(updateOrderUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ items: data })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Cập nhật thứ tự thành công');
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi cập nhật thứ tự:', error);
                });
            }
        });
    </script>
    @endpush
</x-app-layout> 