@extends('layouts.admin')

@section('title', 'Cài đặt hệ thống')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Cài đặt hệ thống</h1>
        <p class="mt-1 text-sm text-gray-600">Quản lý các thiết lập chung của hệ thống</p>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 gap-y-8 gap-x-6 sm:grid-cols-6">
                <div class="sm:col-span-6">
                    <h2 class="text-xl font-medium text-gray-900 border-b pb-3">Thông tin trang web</h2>
                </div>

                <form action="{{ route('admin.settings.update') }}" method="POST" class="sm:col-span-6 space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="site_name" class="block text-sm font-medium text-gray-700">Tên trang web</label>
                            <div class="mt-1">
                                <input type="text" name="site_name" id="site_name" value="{{ $settings->site_name ?? 'RentHouse' }}" 
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="site_description" class="block text-sm font-medium text-gray-700">Mô tả trang web</label>
                            <div class="mt-1">
                                <input type="text" name="site_description" id="site_description" value="{{ $settings->site_description ?? 'Nền tảng cho thuê nhà trực tuyến' }}" 
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="contact_email" class="block text-sm font-medium text-gray-700">Email liên hệ</label>
                            <div class="mt-1">
                                <input type="email" name="contact_email" id="contact_email" value="{{ $settings->contact_email ?? 'contact@renthouse.com' }}" 
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="contact_phone" class="block text-sm font-medium text-gray-700">Số điện thoại liên hệ</label>
                            <div class="mt-1">
                                <input type="text" name="contact_phone" id="contact_phone" value="{{ $settings->contact_phone ?? '+84 123 456 789' }}" 
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <label for="footer_text" class="block text-sm font-medium text-gray-700">Nội dung footer</label>
                            <div class="mt-1">
                                <textarea id="footer_text" name="footer_text" rows="3" 
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $settings->footer_text ?? '© ' . date('Y') . ' RentHouse. Tất cả quyền được bảo lưu.' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-6 pt-5 border-t border-gray-200">
                        <h2 class="text-xl font-medium text-gray-900 pb-3">Cài đặt email</h2>
                    </div>

                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="mail_host" class="block text-sm font-medium text-gray-700">Mail Host</label>
                            <div class="mt-1">
                                <input type="text" name="mail_host" id="mail_host" value="{{ $settings->mail_host ?? 'smtp.mailtrap.io' }}" 
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="mail_port" class="block text-sm font-medium text-gray-700">Mail Port</label>
                            <div class="mt-1">
                                <input type="text" name="mail_port" id="mail_port" value="{{ $settings->mail_port ?? '2525' }}" 
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="mail_username" class="block text-sm font-medium text-gray-700">Mail Username</label>
                            <div class="mt-1">
                                <input type="text" name="mail_username" id="mail_username" value="{{ $settings->mail_username ?? '' }}" 
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="mail_password" class="block text-sm font-medium text-gray-700">Mail Password</label>
                            <div class="mt-1">
                                <input type="password" name="mail_password" id="mail_password" value="{{ $settings->mail_password ?? '' }}" 
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="mail_encryption" class="block text-sm font-medium text-gray-700">Mail Encryption</label>
                            <div class="mt-1">
                                <select id="mail_encryption" name="mail_encryption" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="tls" {{ ($settings->mail_encryption ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS</option>
                                    <option value="ssl" {{ ($settings->mail_encryption ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                    <option value="null" {{ ($settings->mail_encryption ?? '') == '' ? 'selected' : '' }}>Không mã hóa</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="mail_from_address" class="block text-sm font-medium text-gray-700">Địa chỉ gửi mail</label>
                            <div class="mt-1">
                                <input type="email" name="mail_from_address" id="mail_from_address" value="{{ $settings->mail_from_address ?? 'noreply@renthouse.com' }}" 
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-6 pt-5 border-t border-gray-200">
                        <h2 class="text-xl font-medium text-gray-900 pb-3">Cài đặt hệ thống</h2>
                    </div>

                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="registration_enabled" class="block text-sm font-medium text-gray-700">Cho phép đăng ký</label>
                            <div class="mt-1">
                                <select id="registration_enabled" name="registration_enabled" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="1" {{ ($settings->registration_enabled ?? '1') == '1' ? 'selected' : '' }}>Bật</option>
                                    <option value="0" {{ ($settings->registration_enabled ?? '1') == '0' ? 'selected' : '' }}>Tắt</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="maintenance_mode" class="block text-sm font-medium text-gray-700">Chế độ bảo trì</label>
                            <div class="mt-1">
                                <select id="maintenance_mode" name="maintenance_mode" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="0" {{ ($settings->maintenance_mode ?? '0') == '0' ? 'selected' : '' }}>Tắt</option>
                                    <option value="1" {{ ($settings->maintenance_mode ?? '0') == '1' ? 'selected' : '' }}>Bật</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="max_upload_size" class="block text-sm font-medium text-gray-700">Kích thước tối đa upload (MB)</label>
                            <div class="mt-1">
                                <input type="number" name="max_upload_size" id="max_upload_size" value="{{ $settings->max_upload_size ?? '5' }}" 
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="items_per_page" class="block text-sm font-medium text-gray-700">Số mục trên mỗi trang</label>
                            <div class="mt-1">
                                <input type="number" name="items_per_page" id="items_per_page" value="{{ $settings->items_per_page ?? '10' }}" 
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-5">
                        <div class="flex justify-end">
                            <button type="button" onclick="window.location='{{ route('admin.dashboard') }}'" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Hủy
                            </button>
                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Lưu thay đổi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 