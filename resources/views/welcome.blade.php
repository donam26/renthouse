<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name', 'WINHOMES') }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Nunito', sans-serif;
                background-color: #f8fafc;
            }
            .hero-bg {
                background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative min-h-screen">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-gray-800">
                            <span class="text-indigo-600">WIN</span>HOMES
                        </h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="px-4 py-2 text-indigo-600 hover:text-indigo-800">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Đăng ký</a>
                    </div>
                </div>
            </header>

            <!-- Hero Section -->
            <section class="hero-bg py-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
                    <h2 class="text-4xl sm:text-5xl font-bold mb-6">Tìm nhà cho thuê dễ dàng</h2>
                    <p class="text-xl mb-8 max-w-3xl mx-auto">Nền tảng kết nối người cho thuê và người thuê nhà đơn giản, hiệu quả</p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-gray-100">
                            Bắt đầu ngay
                        </a>
                        <a href="#features" class="px-8 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-indigo-700">
                            Tìm hiểu thêm
                        </a>
                    </div>
                </div>
            </section>

            <!-- Features Section -->
            <section id="features" class="py-16 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-bold text-center mb-12 text-gray-900">Tính năng nổi bật</h2>
                    
                    <div class="grid md:grid-cols-3 gap-8">
                        <div class="p-6 border rounded-lg bg-white shadow-sm hover:shadow-md transition">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                                <i class="fas fa-home text-indigo-600 text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-2 text-gray-900">Đa dạng lựa chọn</h3>
                            <p class="text-gray-600">Nhiều loại hình nhà cho thuê từ căn hộ, nhà phố đến biệt thự đáp ứng mọi nhu cầu</p>
                        </div>
                        
                        <div class="p-6 border rounded-lg bg-white shadow-sm hover:shadow-md transition">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                                <i class="fas fa-search text-indigo-600 text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-2 text-gray-900">Tìm kiếm thông minh</h3>
                            <p class="text-gray-600">Dễ dàng lọc theo khu vực, mức giá, diện tích và các tiện ích theo nhu cầu cá nhân</p>
                        </div>
                        
                        <div class="p-6 border rounded-lg bg-white shadow-sm hover:shadow-md transition">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                                <i class="fas fa-shield-alt text-indigo-600 text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-2 text-gray-900">An toàn & Tin cậy</h3>
                            <p class="text-gray-600">Thông tin minh bạch, xác thực người dùng để đảm bảo giao dịch an toàn</p>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Footer -->
            <footer class="bg-gray-800 text-white py-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row justify-between">
                        <div class="mb-6 md:mb-0">
                            <h3 class="text-xl font-bold mb-2">
                                <span class="text-indigo-400">WIN</span>HOMES
                            </h3>
                            <p class="text-gray-400">Nền tảng cho thuê nhà hàng đầu</p>
                        </div>
                        
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                            <div>
                                <h4 class="text-lg font-semibold mb-3">Dịch vụ</h4>
                                <ul class="space-y-2 text-gray-400">
                                    <li><a href="#" class="hover:text-white">Tìm nhà</a></li>
                                    <li><a href="#" class="hover:text-white">Đăng tin</a></li>
                                    <li><a href="#" class="hover:text-white">Quản lý nhà</a></li>
                                </ul>
                            </div>
                            
                            <div>
                                <h4 class="text-lg font-semibold mb-3">Về chúng tôi</h4>
                                <ul class="space-y-2 text-gray-400">
                                    <li><a href="#" class="hover:text-white">Giới thiệu</a></li>
                                    <li><a href="#" class="hover:text-white">Liên hệ</a></li>
                                    <li><a href="#" class="hover:text-white">Điều khoản</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
                        <p>&copy; {{ date('Y') }} WINHOMES. Tất cả quyền được bảo lưu.</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
