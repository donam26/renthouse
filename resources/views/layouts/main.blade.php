<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hệ thống quản lý nhà cho thuê')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
        }
        
        .btn-primary {
            @apply px-5 py-2.5 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 ease-in-out transform hover:-translate-y-0.5;
        }
        
        .btn-secondary {
            @apply px-5 py-2.5 bg-white text-gray-700 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition duration-300 ease-in-out;
        }
        
        .card {
            @apply bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300;
        }
        
        .navbar-item {
            @apply px-4 py-2.5 text-gray-600 hover:text-indigo-600 rounded-lg hover:bg-indigo-50 transition duration-200 font-medium flex items-center;
        }
        
        .dropdown-item {
            @apply flex items-center w-full px-4 py-3 text-left text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition duration-200;
        }
        
        .input-field {
            @apply block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50;
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        
        .icon-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            margin-right: 8px;
        }

        .dropdown-menu {
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #f1f5f9;
        }

        .user-menu-button {
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            background-color: white;
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease;
        }

        .user-menu-button:hover {
            background-color: #f8fafc;
            border-color: #cbd5e1;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }

        .submenu-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    <div x-data="{ mobileMenuOpen: false, userMenuOpen: false }" class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-white shadow-sm sticky top-0 z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <a href="{{ Auth::check() ? '/' . Auth::user()->username : '/' }}" class="flex-shrink-0 flex items-center">
                            <span class="text-2xl font-bold text-indigo-600">WIN<span class="text-gray-800">HOMES</span></span>
                        </a>
                    </div>
                    
                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-3">
                        @auth
                            <a href="/{{ Auth::user()->username }}" class="navbar-item">
                                <div class="icon-wrapper text-indigo-500">
                                    <i class="fas fa-home"></i>
                                </div>
                                <span>Nhà của tôi</span>
                            </a>
                            <a href="{{ route('houses.create') }}" class="navbar-item">
                                <div class="icon-wrapper text-indigo-500">
                                    <i class="fas fa-plus-circle"></i>
                                </div>
                                <span>Thêm nhà mới</span>
                            </a>
                            <div class="relative ml-2" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false" class="user-menu-button">
                                    <div class="h-8 w-8 rounded-full bg-indigo-500 text-white flex items-center justify-center font-bold mr-2">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                                    <div class="ml-2 text-gray-500">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </div>
                                </button>
                                
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-200" 
                                     x-transition:enter-start="opacity-0 scale-95" 
                                     x-transition:enter-end="opacity-100 scale-100" 
                                     x-transition:leave="transition ease-in duration-150" 
                                     x-transition:leave-start="opacity-100 scale-100" 
                                     x-transition:leave-end="opacity-0 scale-95" 
                                     class="absolute right-0 z-10 mt-2 w-56 origin-top-right dropdown-menu bg-white" 
                                     style="display: none;">
                                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-100">
                                        <p class="text-sm text-gray-500">Đã đăng nhập với</p>
                                        <p class="text-sm font-medium text-gray-800 truncate">{{ Auth::user()->email }}</p>
                                    </div>
                                    <div class="py-1">
                                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                            <div class="submenu-icon text-indigo-500">
                                                <i class="fas fa-user-edit"></i>
                                            </div>
                                            <span>Hồ sơ</span>
                                        </a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item w-full">
                                                <div class="submenu-icon text-indigo-500">
                                                    <i class="fas fa-sign-out-alt"></i>
                                                </div>
                                                <span>Đăng xuất</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="navbar-item">
                                <div class="icon-wrapper text-indigo-500">
                                    <i class="fas fa-sign-in-alt"></i>
                                </div>
                                <span>Đăng nhập</span>
                            </a>
                          
                        @endauth
                    </div>
                    
                    <!-- Mobile menu button -->
                    <div class="flex items-center md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:text-indigo-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 transition-colors duration-200">
                            <i x-show="!mobileMenuOpen" class="fas fa-bars text-xl"></i>
                            <i x-show="mobileMenuOpen" class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div x-show="mobileMenuOpen" class="md:hidden bg-white border-t shadow-lg" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-y-90" x-transition:enter-end="opacity-100 transform scale-y-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-y-100" x-transition:leave-end="opacity-0 transform scale-y-90">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    @auth
                        <a href="/{{ Auth::user()->username }}" class="block navbar-item py-3">
                            <div class="icon-wrapper text-indigo-500">
                                <i class="fas fa-home"></i>
                            </div>
                            <span>Nhà của tôi</span>
                        </a>
                        <a href="{{ route('houses.create') }}" class="block navbar-item py-3">
                            <div class="icon-wrapper text-indigo-500">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <span>Thêm nhà mới</span>
                        </a>
                        <hr class="my-2 border-gray-200">
                        <div class="pt-2 pb-1 px-3">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-indigo-500 text-white flex items-center justify-center font-bold mr-3">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-medium text-base">{{ Auth::user()->name }}</div>
                                    <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="block navbar-item py-3">
                            <div class="icon-wrapper text-indigo-500">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <span>Hồ sơ</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left navbar-item py-3">
                                <div class="icon-wrapper text-indigo-500">
                                    <i class="fas fa-sign-out-alt"></i>
                                </div>
                                <span>Đăng xuất</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block navbar-item py-3">
                            <div class="icon-wrapper text-indigo-500">
                                <i class="fas fa-sign-in-alt"></i>
                            </div>
                            <span>Đăng nhập</span>
                        </a>
                        
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Header Section -->
        <header class="gradient-bg text-white">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                @yield('header', '<h1 class="text-2xl font-bold">Dashboard</h1>')
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow max-w-7xl w-full mx-auto py-8 px-4 sm:px-6 lg:px-8 fade-in">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">WINHOMES</h3>
                        <p class="text-gray-300">Nền tảng quản lý nhà cho thuê đơn giản và hiệu quả.</p>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Liên kết nhanh</h3>
                        <ul class="space-y-2">
                            <li><a href="/" class="text-gray-300 hover:text-white transition">Trang chủ</a></li>
                            <li><a href="{{ route('houses.index') }}" class="text-gray-300 hover:text-white transition">Nhà của tôi</a></li>
                            @guest
                            <li><a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition">Đăng nhập</a></li>
                            @endguest
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Liên hệ</h3>
                        <ul class="space-y-2">
                            <li class="flex items-center">
                                <div class="icon-wrapper text-gray-300">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <span>info@winhomes.com</span>
                            </li>
                            <li class="flex items-center">
                                <div class="icon-wrapper text-gray-300">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <span>+84 123 456 789</span>
                            </li>
                            <li class="flex items-center">
                                <div class="icon-wrapper text-gray-300">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <span>Hà Nội, Việt Nam</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-gray-700 mt-8 pt-6 flex flex-col md:flex-row justify-between items-center">
                    <p>&copy; {{ date('Y') }} WINHOMES. Đã đăng ký bản quyền.</p>
                    <div class="flex space-x-4 mt-4 md:mt-0">
                        <a href="#" class="text-gray-300 hover:text-white">
                            <div class="icon-wrapper">
                                <i class="fab fa-facebook"></i>
                            </div>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white">
                            <div class="icon-wrapper">
                                <i class="fab fa-twitter"></i>
                            </div>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white">
                            <div class="icon-wrapper">
                                <i class="fab fa-instagram"></i>
                            </div>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white">
                            <div class="icon-wrapper">
                                <i class="fab fa-linkedin"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    
    <!-- Flash Messages -->
    @if (session('success'))
        <div id="flash-message" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-xl flex items-center fade-in">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('success') }}</span>
            <button onclick="this.parentNode.style.display='none'" class="ml-4 text-white focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif
    
    <!-- Scripts -->
    <script>
        // Auto-hide flash messages
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                setTimeout(function() {
                    flashMessage.style.opacity = '0';
                    setTimeout(function() {
                        flashMessage.style.display = 'none';
                    }, 500);
                }, 5000);
            }
        });
    </script>
    @stack('scripts')
</body>
</html> 