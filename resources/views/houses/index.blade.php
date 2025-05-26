@extends('layouts.main')

@section('title', 'Nhà cho thuê của tôi')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-2xl md:text-3xl font-bold">Danh sách nhà cho thuê của tôi</h1>
        <a href="{{ route('houses.create') }}" class="btn-primary inline-flex items-center">
            <i class="fas fa-plus-circle mr-2"></i> Thêm nhà mới
        </a>
    </div>
@endsection

@section('content')
    <div class="mb-6 flex items-center justify-between bg-white rounded-lg p-4 shadow-sm">
        <h2 class="text-lg font-medium">
            <i class="fas fa-home text-indigo-500 mr-2"></i>
            Quản lý tài sản của bạn
        </h2>
        <div class="text-sm text-gray-500">
            Tổng số: <span class="font-semibold">{{ $houses->count() }} nhà</span>
        </div>
    </div>
    
    @if ($houses->isEmpty())
        <div class="card p-12 text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/6598/6598519.png" alt="Không có nhà" class="w-32 h-32 mx-auto mb-6 opacity-50">
            <h3 class="text-xl font-bold text-gray-700">Bạn chưa có nhà cho thuê nào</h3>
            <p class="text-gray-500 my-4">Bắt đầu thêm các nhà cho thuê của bạn để quản lý dễ dàng hơn.</p>
            <a href="{{ route('houses.create') }}" class="btn-primary inline-flex items-center mt-2">
                <i class="fas fa-plus-circle mr-2"></i> Thêm nhà mới ngay
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($houses as $house)
                <div class="card group">
                    <div class="relative h-56 overflow-hidden">
                        @if ($house->image_path)
                            <img src="{{ asset('storage/' . $house->image_path) }}" alt="{{ $house->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="flex items-center justify-center h-full bg-gray-100 group-hover:bg-gray-200 transition-colors">
                                <i class="fas fa-home text-6xl text-gray-300"></i>
                            </div>
                        @endif
                        
                        <div class="absolute top-3 right-3 flex flex-col space-y-2">
                            <span class="px-3 py-1 text-xs font-bold rounded-full 
                                {{ $house->status === 'available' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }} shadow-md">
                                {{ $house->status === 'available' ? 'Còn trống' : 'Đã thuê' }}
                            </span>
                            
                            @if ($house->house_type)
                                <span class="px-3 py-1 text-xs font-bold bg-blue-500 text-white rounded-full shadow-md">
                                    {{ $house->house_type }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-bold text-gray-800 truncate group-hover:text-indigo-600 transition-colors">{{ $house->name }}</h3>
                            <div class="text-right">
                                <p class="text-lg font-bold text-green-600">{{ number_format($house->rent_price) }} <span class="text-sm font-normal">VND</span></p>
                                @if ($house->deposit_price)
                                    <p class="text-xs text-gray-500">Đặt cọc: {{ number_format($house->deposit_price) }} VND</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <p class="text-gray-600 flex items-start">
                                <i class="fas fa-map-marker-alt w-5 text-indigo-500"></i>
                                <span class="truncate">{{ $house->address }}</span>
                            </p>
                            
                            @if ($house->location)
                                <p class="text-gray-500 text-sm mt-1 flex items-center">
                                    <i class="fas fa-location-dot w-5 text-gray-400"></i>
                                    <span>{{ $house->location }}</span>
                                </p>
                            @endif
                        </div>
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            @if ($house->transportation)
                                <span class="inline-flex items-center bg-indigo-100 text-indigo-800 text-xs px-2.5 py-1 rounded-full">
                                    <i class="fas fa-{{ $house->transportation == 'Xe đạp' ? 'bicycle' : ($house->transportation == 'Tàu' ? 'train' : 'bus') }} mr-1.5"></i>
                                    {{ $house->transportation }}
                                </span>
                            @endif
                            
                            @if ($house->distance)
                                <span class="inline-flex items-center bg-indigo-100 text-indigo-800 text-xs px-2.5 py-1 rounded-full">
                                    <i class="fas fa-walking mr-1.5"></i>
                                    {{ $house->distance }}m
                                </span>
                            @endif
                        </div>
                        
                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <a href="{{ route('houses.show', $house) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition">
                                <span>Chi tiết</span>
                                <i class="fas fa-chevron-right ml-1 text-xs"></i>
                            </a>
                            
                            <div class="flex space-x-2">
                                <a href="{{ route('houses.edit', $house) }}" class="p-2 text-blue-500 hover:bg-blue-50 rounded-full transition tooltip" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="{{ route('houses.destroy', $house) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-full transition tooltip" 
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa nhà này không?')"
                                        title="Xóa">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <style>
            .tooltip {
                position: relative;
            }
            
            .tooltip:hover:after {
                content: attr(title);
                position: absolute;
                bottom: 100%;
                left: 50%;
                transform: translateX(-50%);
                background: rgba(0,0,0,0.7);
                color: white;
                padding: 4px 8px;
                border-radius: 4px;
                font-size: 12px;
                white-space: nowrap;
                margin-bottom: 5px;
            }
            
            .tooltip:hover:before {
                content: '';
                position: absolute;
                bottom: 100%;
                left: 50%;
                transform: translateX(-50%);
                border-width: 5px;
                border-style: solid;
                border-color: rgba(0,0,0,0.7) transparent transparent transparent;
                rotate: 180deg;
            }
        </style>
    @endif
@endsection 