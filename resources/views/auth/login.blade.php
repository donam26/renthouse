<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập | {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #f0f5ff 0%, #e6eeff 100%);
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-card {
            border-radius: 1.5rem;
            box-shadow: 0 20px 40px -10px rgba(59, 130, 246, 0.15), 0 10px 20px -5px rgba(59, 130, 246, 0.1);
            overflow: hidden;
            position: relative;
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
        .login-card::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            border-radius: 50%;
            top: -200px;
            left: -200px;
            z-index: 0;
            opacity: 0.08;
        }
        .login-card::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #3b82f6, #4f46e5);
            border-radius: 50%;
            bottom: -150px;
            right: -150px;
            z-index: 0;
            opacity: 0.08;
        }
        .card-content {
            position: relative;
            z-index: 1;
        }
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 2rem 0;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }
        .divider span {
            margin: 0 1rem;
            color: #94a3b8;
        }
        .animated-gradient {
            background: linear-gradient(-45deg, #4f46e5, #3b82f6, #2563eb, #1d4ed8);
            background-size: 400% 400%;
            animation: gradient 8s ease infinite;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .input-container {
            position: relative;
        }
        .input-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 15px;
            color: #818cf8;
            font-size: 1.2rem;
            z-index: 10;
            width: 20px;
            text-align: center;
        }
        .form-input {
            width: 100%;
            padding: 16px 16px 16px 45px;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.75rem;
            border: 1px solid #d1d5db;
            background-color: #fff;
            transition: all 0.2s ease;
        }
        .form-input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }
    </style>
</head>
<body>
    <div class="login-container px-4">
        <div class="w-full max-w-md">
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                </div>
            @endif
            
            <!-- Error Message -->
            @if (session('error'))
                <div class="p-4 mb-4 text-base text-white bg-red-500 rounded-xl shadow-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif
            
            <div class="login-card">
                <div class="card-content p-10">
                    <div class="text-center mb-8">
                        <h1 class="text-4xl font-bold mb-2">
                            <span class="animated-gradient">WIN</span><span class="text-gray-800">HOMES</span>
                        </h1>
                        <p class="mt-3 text-gray-600 text-lg">Đăng nhập để quản lý nhà cho thuê</p>
                    </div>
                    
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Email/Username -->
                        <div>
                            <label for="email" class="block text-base font-medium text-gray-700 mb-2">Email</label>
                            <div class="input-container">
                                <span class="input-icon">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                                    class="form-input" placeholder="name@example.com">
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Password -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="password" class="block text-base font-medium text-gray-700">Mật khẩu</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-500 font-medium">
                                        Quên mật khẩu?
                                    </a>
                                @endif
                            </div>
                            <div class="input-container">
                                <span class="input-icon">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input id="password" type="password" name="password" required autocomplete="current-password" 
                                    class="form-input" placeholder="••••••••">
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" name="remember" class="h-5 w-5 text-indigo-600 border-gray-300 rounded-md focus:ring-indigo-500 cursor-pointer">
                            <label for="remember_me" class="ml-3 block text-base text-gray-700">
                                Ghi nhớ đăng nhập
                            </label>
                        </div>
                        
                        <button type="submit" class="w-full py-4 px-6 bg-indigo-600 text-white text-base font-bold rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-3 focus:ring-indigo-500/50 focus:ring-offset-2 transition duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-xl mt-8">
                            <span class="flex items-center justify-center">
                                <i class="fas fa-sign-in-alt mr-2 text-lg"></i>
                                Đăng nhập
                            </span>
                        </button>
                    </form>
                  
                </div>
            </div>
        </div>
    </div>
</body>
</html>
