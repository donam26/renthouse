@extends('layouts.admin')

@section('title', 'Chỉnh sửa người dùng')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="section-header">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Chỉnh sửa người dùng</h1>
            <p class="mt-1 text-sm text-gray-600">Cập nhật thông tin người dùng: {{ $user->name }}</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.users.index') }}" class="btn-secondary inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
            </a>
        </div>
    </div>

    <div class="card shadow-md">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <label for="name" class="form-label">Tên người dùng <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                        class="input-field @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-3">
                    <label for="email" class="form-label">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                        class="input-field @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-3">
                    <label for="username" class="form-label">Tên đăng nhập</label>
                    <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                        class="input-field @error('username') border-red-500 @enderror">
                    @error('username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-3">
                    <label for="phone_number" class="form-label">Số điện thoại</label>
                    <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                        class="input-field @error('phone_number') border-red-500 @enderror">
                    @error('phone_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-3">
                    <label for="password" class="form-label">Mật khẩu mới (để trống nếu không đổi)</label>
                    <input type="password" name="password" id="password"
                        class="input-field @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-3">
                    <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="input-field">
                </div>

                <div class="sm:col-span-3">
                    <label for="status" class="form-label">Trạng thái <span class="text-red-500">*</span></label>
                    <select id="status" name="status" class="input-field @error('status') border-red-500 @enderror">
                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                        <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Ngừng hoạt động</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-6">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="is_admin" name="is_admin" type="checkbox" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_admin" class="font-medium text-gray-700">Là quản trị viên</label>
                            <p class="text-gray-500">Người dùng này sẽ có quyền truy cập vào khu vực quản trị.</p>
                        </div>
                    </div>
                    @error('is_admin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-3">
                <a href="{{ route('admin.users.show', $user) }}" class="btn-secondary">
                    Hủy thay đổi
                </a>
                <button type="submit" class="btn-primary inline-flex items-center">
                    <i class="fas fa-save mr-2"></i> Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 