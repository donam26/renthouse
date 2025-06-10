<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Toast Notification Styles -->
        <style>
            .toast-container {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                max-width: 400px;
            }
            
            .toast {
                display: flex;
                align-items: center;
                background: white;
                border-radius: 8px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
                border: 1px solid #e5e7eb;
                margin-bottom: 12px;
                padding: 16px;
                transform: translateX(100%);
                opacity: 0;
                transition: all 0.3s ease-in-out;
                max-width: 100%;
                word-wrap: break-word;
            }
            
            .toast.show {
                transform: translateX(0);
                opacity: 1;
            }
            
            .toast.success {
                border-left: 4px solid #10b981;
            }
            
            .toast.error {
                border-left: 4px solid #ef4444;
            }
            
            .toast.warning {
                border-left: 4px solid #f59e0b;
            }
            
            .toast.info {
                border-left: 4px solid #3b82f6;
            }
            
            .toast-icon {
                flex-shrink: 0;
                width: 24px;
                height: 24px;
                margin-right: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
            }
            
            .toast.success .toast-icon {
                background-color: #d1fae5;
                color: #10b981;
            }
            
            .toast.error .toast-icon {
                background-color: #fee2e2;
                color: #ef4444;
            }
            
            .toast.warning .toast-icon {
                background-color: #fef3c7;
                color: #f59e0b;
            }
            
            .toast.info .toast-icon {
                background-color: #dbeafe;
                color: #3b82f6;
            }
            
            .toast-content {
                flex-grow: 1;
                font-size: 14px;
                line-height: 1.5;
            }
            
            .toast-title {
                font-weight: 600;
                color: #374151;
                margin-bottom: 2px;
            }
            
            .toast-message {
                color: #6b7280;
            }
            
            .toast-close {
                flex-shrink: 0;
                margin-left: 12px;
                background: none;
                border: none;
                color: #9ca3af;
                cursor: pointer;
                padding: 4px;
                border-radius: 4px;
                transition: all 0.2s;
            }
            
            .toast-close:hover {
                color: #6b7280;
                background-color: #f3f4f6;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        
        <!-- Toast Notification Container -->
        <div class="toast-container" id="toast-container"></div>
        
        <!-- Toast Notification Script -->
        <script>
            class ToastNotification {
                constructor() {
                    this.container = document.getElementById('toast-container');
                }
                
                show(message, type = 'success', title = null, duration = 4000) {
                    const toast = this.createToast(message, type, title);
                    this.container.appendChild(toast);
                    
                    // Trigger animation
                    setTimeout(() => {
                        toast.classList.add('show');
                    }, 10);
                    
                    // Auto remove
                    if (duration > 0) {
                        setTimeout(() => {
                            this.remove(toast);
                        }, duration);
                    }
                    
                    return toast;
                }
                
                createToast(message, type, title) {
                    const toast = document.createElement('div');
                    toast.className = `toast ${type}`;
                    
                    const icons = {
                        success: 'fas fa-check',
                        error: 'fas fa-times',
                        warning: 'fas fa-exclamation-triangle',
                        info: 'fas fa-info-circle'
                    };
                    
                    const titles = {
                        success: title || 'Thành công!',
                        error: title || 'Lỗi!',
                        warning: title || 'Cảnh báo!',
                        info: title || 'Thông tin!'
                    };
                    
                    toast.innerHTML = `
                        <div class="toast-icon">
                            <i class="${icons[type]}"></i>
                        </div>
                        <div class="toast-content">
                            <div class="toast-title">${titles[type]}</div>
                            <div class="toast-message">${message}</div>
                        </div>
                        <button class="toast-close" onclick="window.toast.remove(this.closest('.toast'))">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    
                    return toast;
                }
                
                remove(toast) {
                    toast.classList.remove('show');
                    setTimeout(() => {
                        if (toast.parentNode) {
                            toast.parentNode.removeChild(toast);
                        }
                    }, 300);
                }
                
                success(message, title = null) {
                    return this.show(message, 'success', title);
                }
                
                error(message, title = null) {
                    return this.show(message, 'error', title);
                }
                
                warning(message, title = null) {
                    return this.show(message, 'warning', title);
                }
                
                info(message, title = null) {
                    return this.show(message, 'info', title);
                }
            }
            
            // Khởi tạo toast notification toàn cục
            window.toast = new ToastNotification();
        </script>
        
        @stack('scripts')
    </body>
</html>
