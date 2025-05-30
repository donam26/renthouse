@extends('layouts.admin')

@section('title', 'Bảng điều khiển Admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-gray-900">Bảng điều khiển</h1>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Thống kê người dùng -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Tổng số người dùng
                                </dt>
                                <dd>
                                    <div class="text-lg font-medium text-gray-900">{{ $totalUsers }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('admin.users.index') }}" class="font-medium text-indigo-600 hover:text-indigo-900">
                            Xem tất cả
                        </a>
                    </div>
                </div>
            </div>

            <!-- Thống kê nhà cho thuê -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-home text-white"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Tổng số nhà cho thuê
                                </dt>
                                <dd>
                                    <div class="text-lg font-medium text-gray-900">{{ $totalHouses }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('admin.houses.index') }}" class="font-medium text-indigo-600 hover:text-indigo-900">
                            Xem tất cả
                        </a>
                    </div>
                </div>
            </div>

            <!-- Thống kê nhà đã thuê -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
              
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('admin.houses.index', ['status' => 'rented']) }}" class="font-medium text-indigo-600 hover:text-indigo-900">
                            Xem tất cả
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hoạt động gần đây -->
        <div class="mt-8">
            <h2 class="text-lg leading-6 font-medium text-gray-900">Hoạt động gần đây</h2>
            <div class="mt-4 bg-white shadow overflow-hidden sm:rounded-md">
                <ul role="list" class="divide-y divide-gray-200">
                    @forelse($recentActivities as $activity)
                    <li>
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-100">
                                            <i class="fas fa-user-circle text-indigo-600"></i>
                                        </span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-indigo-600">
                                            {{ $activity->user->name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $activity->description }}
                                        </p>
                                    </div>
                                </div>
                                <div class="ml-2 flex-shrink-0">
                                    <p class="text-sm text-gray-500">
                                        {{ $activity->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="px-4 py-4 sm:px-6 text-center text-gray-500">
                        Không có hoạt động gần đây
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection 