<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Quản trị Rent House') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">
        <!-- Mobile sidebar backdrop -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 md:hidden" 
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"></div>

        <!-- Sidebar -->
        <div x-show="sidebarOpen" class="fixed inset-0 flex z-40 md:hidden"
            x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full">
            
            <div class="relative flex-1 flex flex-col max-w-xs w-full bg-indigo-800">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button @click="sidebarOpen = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Đóng sidebar</span>
                        <i class="fas fa-times text-white"></i>
                    </button>
                </div>
                
                <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                    <div class="flex-shrink-0 flex items-center px-4">
                        <h1 class="text-white font-bold text-xl">RentHouse Admin</h1>
                    </div>
                    <nav class="mt-5 px-2 space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="navbar-item {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700 hover:text-white' }}">
                            <i class="fas fa-tachometer-alt mr-3 text-indigo-300"></i>
                            Bảng điều khiển
                        </a>
                        
                        <a href="{{ route('admin.users.index') }}" class="navbar-item {{ request()->routeIs('admin.users.*') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700 hover:text-white' }}">
                            <i class="fas fa-users mr-3 text-indigo-300"></i>
                            Quản lý người dùng
                        </a>
                        
                        <a href="{{ route('admin.houses.index') }}" class="navbar-item {{ request()->routeIs('admin.houses.*') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700 hover:text-white' }}">
                            <i class="fas fa-home mr-3 text-indigo-300"></i>
                            Quản lý nhà cho thuê
                        </a>

                        <a href="{{ route('admin.settings') }}" class="navbar-item {{ request()->routeIs('admin.settings') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700 hover:text-white' }}">
                            <i class="fas fa-cog mr-3 text-indigo-300"></i>
                            Cài đặt hệ thống
                        </a>
                    </nav>
                </div>
                <div class="flex-shrink-0 flex border-t border-indigo-700 p-4">
                    <div class="flex-shrink-0 group block">
                        <div class="flex items-center">
                            <div class="ml-3">
                                <p class="text-base font-medium text-white">{{ Auth::user()->name }}</p>
                                <p class="text-sm font-medium text-indigo-200 group-hover:text-white">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                                        Đăng xuất
                                    </a>
                                </p>
                                <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex-shrink-0 w-14">
                <!-- Force sidebar to shrink to fit close icon -->
            </div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            <div class="flex-1 flex flex-col min-h-0 bg-indigo-800">
                <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                    <div class="flex items-center flex-shrink-0 px-4">
                        <h1 class="text-white font-bold text-xl">RentHouse Admin</h1>
                    </div>
                    <nav class="mt-5 flex-1 px-2 space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="navbar-item {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700 hover:text-white' }}">
                            <i class="fas fa-tachometer-alt mr-3 text-indigo-300"></i>
                            Bảng điều khiển
                        </a>
                        
                        <a href="{{ route('admin.users.index') }}" class="navbar-item {{ request()->routeIs('admin.users.*') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700 hover:text-white' }}">
                            <i class="fas fa-users mr-3 text-indigo-300"></i>
                            Quản lý người dùng
                        </a>
                        
                        <a href="{{ route('admin.houses.index') }}" class="navbar-item {{ request()->routeIs('admin.houses.*') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700 hover:text-white' }}">
                            <i class="fas fa-home mr-3 text-indigo-300"></i>
                            Quản lý nhà cho thuê
                        </a>

                        <a href="{{ route('admin.settings') }}" class="navbar-item {{ request()->routeIs('admin.settings') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700 hover:text-white' }}">
                            <i class="fas fa-cog mr-3 text-indigo-300"></i>
                            Cài đặt hệ thống
                        </a>
                    </nav>
                </div>
                <div class="flex-shrink-0 flex border-t border-indigo-700 p-4">
                    <div class="flex-shrink-0 w-full group block">
                        <div class="flex items-center">
                            <div>
                                <div class="h-9 w-9 rounded-full bg-indigo-700 flex items-center justify-center text-white">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                                <p class="text-xs font-medium text-indigo-200 group-hover:text-white">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Đăng xuất
                                    </a>
                                </p>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main content -->
        <div class="md:pl-64 flex flex-col flex-1">
            <div class="sticky top-0 z-10 md:hidden pl-1 pt-1 sm:pl-3 sm:pt-3 bg-gray-100">
                <button 
                    @click="sidebarOpen = true" 
                    class="-ml-0.5 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                    <span class="sr-only">Mở menu</span>
                    <i class="fas fa-bars h-6 w-6"></i>
                </button>
            </div>
            
            <main>
                <div class="py-6">
                    @if (session('success'))
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
                            <div class="bg-green-50 border-l-4 border-green-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle text-green-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-green-700">
                                            {{ session('success') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
                            <div class="bg-red-50 border-l-4 border-red-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-circle text-red-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-red-700">
                                            {{ session('error') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html> 