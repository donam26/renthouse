@extends('layouts.main')

@section('title', 'Trang cá nhân')

@section('header')
    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold">Quản lý tài khoản</h1>
            <p class="text-gray-100 mt-1">Cập nhật thông tin và cài đặt tài khoản của bạn</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Bảng điều khiển bên trái -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                <div class="flex flex-col items-center text-center mb-6">
                    <div class="h-24 w-24 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white flex-shrink-0 shadow-md mb-4">
                        <span class="text-4xl font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <h3 class="font-semibold text-lg text-gray-800">{{ Auth::user()->name }}</h3>
                    <p class="text-gray-500 text-sm mt-1">{{ Auth::user()->email }}</p>
                </div>
                
                <nav class="space-y-2">
                    <a href="#profile-info" class="flex items-center px-4 py-3 text-indigo-600 bg-indigo-50 rounded-lg font-medium">
                        <i class="fas fa-user mr-3"></i>
                        <span>Thông tin cá nhân</span>
                    </a>
                    <a href="#password" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                        <i class="fas fa-lock mr-3"></i>
                        <span>Mật khẩu</span>
                    </a>
                    <a href="#delete-account" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                        <i class="fas fa-trash-alt mr-3"></i>
                        <span>Xóa tài khoản</span>
                    </a>
                    <a href="{{ route('houses.by.username', Auth::user()->username) }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                        <i class="fas fa-home mr-3"></i>
                        <span>Nhà cho thuê của tôi</span>
                    </a>
                </nav>
            </div>
        </div>
        
        <!-- Khu vực chính -->
        <div class="lg:col-span-3 space-y-6">
            <!-- Thông tin cá nhân -->
            <div id="profile-info" class="bg-white rounded-lg shadow-sm p-6">
                <div class="border-b pb-4 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-user-circle text-indigo-500 mr-3"></i>
                        Thông tin cá nhân
        </h2>
                    <p class="text-gray-500 mt-1">Cập nhật thông tin cá nhân và liên hệ của bạn</p>
                </div>
                
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Mật khẩu -->
            <div id="password" class="bg-white rounded-lg shadow-sm p-6">
                <div class="border-b pb-4 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-lock text-indigo-500 mr-3"></i>
                        Bảo mật
                    </h2>
                    <p class="text-gray-500 mt-1">Đảm bảo tài khoản của bạn được bảo mật với mật khẩu mạnh</p>
                </div>
                
                @include('profile.partials.update-password-form')
            </div>

            <!-- Xóa tài khoản -->
            <div id="delete-account" class="bg-white rounded-lg shadow-sm p-6">
                <div class="border-b pb-4 mb-6">
                    <h2 class="text-xl font-semibold text-red-600 flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                        Vùng nguy hiểm
                    </h2>
                    <p class="text-gray-500 mt-1">Thao tác này sẽ xóa vĩnh viễn tài khoản của bạn</p>
                </div>
                
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lấy tất cả các liên kết điều hướng
        const navLinks = document.querySelectorAll('.lg\\:col-span-1 nav a');
        
        // Xử lý sự kiện cuộn
        window.addEventListener('scroll', function() {
            const scrollPosition = window.scrollY;
            
            // Kiểm tra vị trí của các phần
            document.querySelectorAll('#profile-info, #password, #delete-account').forEach(section => {
                const sectionTop = section.offsetTop - 100;
                const sectionBottom = sectionTop + section.offsetHeight;
                
                if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
                    // ID của phần đang xem
                    const id = section.getAttribute('id');
                    
                    // Xóa lớp active khỏi tất cả các liên kết
                    navLinks.forEach(link => {
                        link.classList.remove('text-indigo-600', 'bg-indigo-50');
                        link.classList.add('text-gray-700', 'hover:bg-gray-50');
                    });
                    
                    // Thêm lớp active vào liên kết tương ứng
                    const activeLink = document.querySelector(`a[href="#${id}"]`);
                    if (activeLink) {
                        activeLink.classList.remove('text-gray-700', 'hover:bg-gray-50');
                        activeLink.classList.add('text-indigo-600', 'bg-indigo-50');
                    }
                }
            });
        });
        
        // Xử lý sự kiện nhấp vào liên kết
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Lấy ID từ href
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    // Cuộn đến phần tương ứng
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                    
                    // Cập nhật URL với fragment
                    history.pushState(null, null, `#${targetId}`);
                    
                    // Cập nhật trạng thái active
                    navLinks.forEach(navLink => {
                        navLink.classList.remove('text-indigo-600', 'bg-indigo-50');
                        navLink.classList.add('text-gray-700', 'hover:bg-gray-50');
                    });
                    
                    this.classList.remove('text-gray-700', 'hover:bg-gray-50');
                    this.classList.add('text-indigo-600', 'bg-indigo-50');
                }
            });
        });
    });
</script>
@endpush
