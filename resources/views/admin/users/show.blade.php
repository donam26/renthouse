@extends('layouts.admin')

@section('title', 'Chi tiết người dùng: ' . $user->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="section-header">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Chi tiết người dùng</h1>
            <p class="mt-1 text-sm text-gray-600">Thông tin chi tiết về người dùng</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn-primary inline-flex items-center">
                <i class="fas fa-edit mr-2"></i> Chỉnh sửa
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn-secondary inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="card shadow-md mb-6">
        <div class="px-4 py-5 sm:px-6 bg-gray-50">
            <div class="flex items-center">
                <div class="h-16 w-16 bg-indigo-600 rounded-full flex items-center justify-center text-white text-xl font-bold mr-4">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        {{ $user->name }}
                        <span class="badge {{ $user->is_admin ? 'badge-info' : 'badge-success' }}">
                            {{ $user->is_admin ? 'Admin' : 'Người dùng' }}
                        </span>
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Thông tin chi tiết người dùng
                    </p>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        ID
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $user->id }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Email
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $user->email }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Username
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $user->username }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Số điện thoại
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $user->phone_number ?: 'Không có' }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Trạng thái
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <span class="badge {{ $user->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                            {{ $user->status === 'active' ? 'Đang hoạt động' : 'Ngừng hoạt động' }}
                        </span>
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Ngày tạo
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $user->created_at ? $user->created_at->format('d/m/Y') : 'Không có' }}

                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Cập nhật lần cuối
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i:s') : 'Không có' }}

                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Nhà cho thuê của người dùng -->
    <div class="mt-8">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Danh sách nhà cho thuê ({{ $houses->total() }})</h2>
        
        @if($houses->isEmpty())
            <div class="card p-6 text-center">
                <i class="fas fa-home text-4xl text-gray-300 mb-3"></i>
                <p class="text-gray-600">Người dùng này chưa có nhà cho thuê nào</p>
            </div>
        @else
            <div class="table-container card">
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($houses as $house)
                        <li class="table-row">
                            <div class="flex items-center px-4 py-4 sm:px-6">
                                <div class="min-w-0 flex-1 flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12 rounded-md overflow-hidden bg-gray-100">
                                        @if($house->image_path)
                                            <img src="{{ asset('storage/' . $house->image_path) }}" alt="{{ $house->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="fas fa-home text-xl text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1 px-4">
                                        <div>
                                            <div class="flex items-center">
                                                <p class="text-sm font-medium text-indigo-600 truncate">{{ $house->name }}</p>
                                                <span class="ml-2 badge {{ $house->status === 'available' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $house->status === 'available' ? 'Còn trống' : 'Đã thuê' }}
                                                </span>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-500">
                                                <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i> {{ $house->address }}
                                            </p>
                                            <p class="mt-1 text-sm text-gray-500">
                                                <span class="font-medium">{{ number_format($house->rent_price) }} VND</span>
                                                @if($house->house_type)
                                                    <span class="mx-2">|</span>
                                                    <span>{{ $house->house_type }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('admin.houses.show', $house) }}" class="btn-primary inline-flex items-center px-3 py-1.5 text-xs">
                                        Xem chi tiết <i class="fas fa-chevron-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            
            <div class="mt-4">
                {{ $houses->links() }}
            </div>
        @endif
    </div>
</div>
@endsection 