@extends('layouts.admin')

@section('title', 'Chi tiết nhà cho thuê')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Chi tiết nhà cho thuê</h1>
                <p class="mt-1 text-sm text-gray-600">Thông tin chi tiết về nhà cho thuê</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <a href="{{ route('admin.houses.edit', $house) }}" class="btn-primary inline-flex items-center">
                    <i class="fas fa-edit mr-2"></i> Chỉnh sửa
                </a>
                <a href="{{ route('admin.houses.index') }}" class="btn-secondary inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Quay lại
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $house->name }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">ID: {{ $house->id }}</p>
            </div>
            <div class="flex items-center space-x-2">
                @if($house->house_type)
                <span class="badge badge-info">
                    {{ $house->house_type }}
                </span>
                @endif
            </div>
        </div>
        
        <div class="border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-8 px-4 py-5 sm:p-6">
                <div class="col-span-1 md:col-span-2">
                    <div class="aspect-w-16 aspect-h-9 bg-gray-100 rounded-lg overflow-hidden">
                        @if($house->image_path)
                            <img src="{{ asset('storage/' . $house->image_path) }}" alt="{{ $house->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-64 flex items-center justify-center">
                                <i class="fas fa-home text-6xl text-gray-300"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-500">Thông tin cơ bản</h4>
                    <div class="mt-4 space-y-4">
                       
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-500">Chủ nhà:</span>
                            <div class="mt-1 flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center text-white">
                                    {{ substr($house->user->name, 0, 1) }}
                                </div>
                                <div class="ml-2">
                                    <div class="text-sm font-medium text-gray-900">{{ $house->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $house->user->email }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-500">Thông tin giá và đặc điểm</h4>
                    <div class="mt-4 space-y-4">
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-500">Giá thuê:</span>
                            <span class="mt-1 text-sm text-gray-900 font-bold text-green-600">{{ number_format($house->rent_price) }} ¥</span>
                        </div>
                        
                        @if($house->input_price)
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-500">Tiền đầu vào:</span>
                            <span class="mt-1 text-sm text-gray-900">{{ number_format($house->input_price) }} ¥</span>
                        </div>
                        @endif
                        
                        @if($house->house_type)
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-500">Loại nhà:</span>
                            <span class="mt-1 text-sm text-gray-900">{{ $house->house_type }}</span>
                        </div>
                        @endif
                        
                        @if($house->distance)
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-500">Khoảng cách:</span>
                            <span class="mt-1 text-sm text-gray-900">{{ $house->distance }} m</span>
                        </div>
                        @endif
                        
                        @if($house->transportation)
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-500">Phương tiện di chuyển:</span>
                            <span class="mt-1 text-sm text-gray-900">{{ $house->transportation }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                
            
                <div class="col-span-1 md:col-span-2">
                    <h4 class="text-sm font-medium text-gray-500">Thông tin khác</h4>
                    <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4">
                        
                        @if($house->share_link)
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-500">Link chia sẻ:</span>
                            <a href="{{ $house->share_link }}" target="_blank" class="mt-1 text-sm text-indigo-600 hover:text-indigo-900 truncate">
                                {{ $house->share_link }}
                            </a>
                        </div>
                        @endif
                        
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-500">Ngày tạo:</span>
                            <span class="mt-1 text-sm text-gray-900">{{ $house->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-500">Cập nhật lần cuối:</span>
                            <span class="mt-1 text-sm text-gray-900">{{ $house->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                    
                    @if($house->description)
                    <div class="mt-4">
                        <span class="text-sm font-medium text-gray-500">Mô tả chi tiết:</span>
                        <div class="mt-2 p-4 bg-gray-100 rounded-lg text-sm text-gray-700">
                            {{ $house->description }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="px-4 py-4 sm:px-6 bg-gray-50 border-t border-gray-200">
            <div class="flex justify-between">
                <form action="{{ route('admin.houses.destroy', $house) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhà này?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <i class="fas fa-trash mr-2"></i> Xóa nhà này
                    </button>
                </form>
                
                <div class="flex space-x-3">
                    <a href="{{ route('admin.houses.edit', $house) }}" class="btn-primary inline-flex items-center">
                        <i class="fas fa-edit mr-2"></i> Chỉnh sửa
                    </a>
                    <a href="{{ route('admin.houses.index') }}" class="btn-secondary inline-flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 