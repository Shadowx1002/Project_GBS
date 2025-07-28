<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel - {{ config('app.name', 'Gel Blaster Store') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- AOS Animation CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 shadow-lg" x-data="{ sidebarOpen: true }">
            <div class="flex items-center justify-center h-16 bg-gray-900">
                <span class="text-white text-lg font-semibold">Admin Panel</span>
            </div>
            
            <nav class="mt-5 px-2">
                <div class="space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v4H8V5z"></path>
                        </svg>
                        Dashboard
                    </a>

                    <!-- Products -->
                    <div class="space-y-1">
                        <button class="admin-nav-button w-full text-left" onclick="toggleSubmenu('products')">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    Products
                                </div>
                                <svg class="h-5 w-5 transform transition-transform" id="products-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>
                        <div class="ml-6 space-y-1 hidden" id="products-submenu">
                            <a href="{{ route('admin.products.index') }}" 
                               class="admin-submenu-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                                All Products
                            </a>
                            <a href="{{ route('admin.products.create') }}" class="admin-submenu-link">
                                Add Product
                            </a>
                        </div>
                    </div>

                    <!-- Orders -->
                    <a href="{{ route('admin.orders.index') }}" 
                       class="admin-nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Orders
                        @if(\App\Models\Order::where('status', 'pending')->count() > 0)
                            <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1">
                                {{ \App\Models\Order::where('status', 'pending')->count() }}
                            </span>
                        @endif
                    </a>

                    <!-- Verifications -->
                    <a href="{{ route('admin.verifications.index') }}" 
                       class="admin-nav-link {{ request()->routeIs('admin.verifications.*') ? 'active' : '' }}">
                        <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Age Verifications
                        @if(\App\Models\UserVerification::where('verification_status', 'pending')->count() > 0)
                            <span class="ml-auto bg-yellow-500 text-white text-xs rounded-full px-2 py-1">
                                {{ \App\Models\UserVerification::where('verification_status', 'pending')->count() }}
                            </span>
                        @endif
                    </a>

                    <!-- Users -->
                    <a href="{{ route('admin.users.index') }}" 
                       class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-1a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Users
                    </a>

                    <!-- Settings -->
                    <div class="pt-4 mt-4 border-t border-gray-700">
                        <a href="{{ route('home') }}" target="_blank" class="admin-nav-link">
                            <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            View Store
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="inline w-full">
                            @csrf
                            <button type="submit" class="admin-nav-link w-full text-left">
                                <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-semibold text-gray-900">
                            @yield('page-title', 'Admin Dashboard')
                        </h1>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="p-2 text-gray-400 hover:text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5V7h5v10z"></path>
                                </svg>
                                @if(\App\Models\Order::where('status', 'pending')->count() > 0 || \App\Models\UserVerification::where('verification_status', 'pending')->count() > 0)
                                    <span class="absolute -top-1 -right-1 h-3 w-3 bg-red-500 rounded-full"></span>
                                @endif
                            </button>
                            
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                                <div class="p-4 border-b border-gray-200">
                                    <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
                                </div>
                                <div class="max-h-64 overflow-y-auto">
                                    @if(\App\Models\Order::where('status', 'pending')->count() > 0)
                                        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="block px-4 py-3 hover:bg-gray-50">
                                            <p class="text-sm text-gray-900">{{ \App\Models\Order::where('status', 'pending')->count() }} pending orders</p>
                                            <p class="text-xs text-gray-500">Require your attention</p>
                                        </a>
                                    @endif
                                    
                                    @if(\App\Models\UserVerification::where('verification_status', 'pending')->count() > 0)
                                        <a href="{{ route('admin.verifications.index', ['status' => 'pending']) }}" class="block px-4 py-3 hover:bg-gray-50">
                                            <p class="text-sm text-gray-900">{{ \App\Models\UserVerification::where('verification_status', 'pending')->count() }} pending verifications</p>
                                            <p class="text-xs text-gray-500">Age verification requests</p>
                                        </a>
                                    @endif
                                    
                                    @if(\App\Models\Order::where('status', 'pending')->count() == 0 && \App\Models\UserVerification::where('verification_status', 'pending')->count() == 0)
                                        <div class="px-4 py-3 text-sm text-gray-500">
                                            No new notifications
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- User Menu -->
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                                <span class="text-primary-700 font-medium text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- AOS Animation Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            duration: 600,
            once: true,
            offset: 50
        });

        // Submenu toggle
        function toggleSubmenu(menuName) {
            const submenu = document.getElementById(menuName + '-submenu');
            const arrow = document.getElementById(menuName + '-arrow');
            
            if (submenu.classList.contains('hidden')) {
                submenu.classList.remove('hidden');
                arrow.style.transform = 'rotate(180deg)';
            } else {
                submenu.classList.add('hidden');
                arrow.style.transform = 'rotate(0deg)';
            }
        }

        // Auto-open active submenus
        document.addEventListener('DOMContentLoaded', function() {
            const activeSubmenuLinks = document.querySelectorAll('.admin-submenu-link.active');
            activeSubmenuLinks.forEach(link => {
                const submenu = link.closest('[id$="-submenu"]');
                if (submenu) {
                    submenu.classList.remove('hidden');
                    const menuName = submenu.id.replace('-submenu', '');
                    const arrow = document.getElementById(menuName + '-arrow');
                    if (arrow) {
                        arrow.style.transform = 'rotate(180deg)';
                    }
                }
            });
        });

        // Auto-refresh notifications every 2 minutes
        setInterval(function() {
            fetch('/admin/notifications/check')
                .then(response => response.json())
                .then(data => {
                    if (data.new_orders > 0 || data.new_verifications > 0) {
                        // Update notification badge
                        location.reload();
                    }
                })
                .catch(error => console.error('Error checking notifications:', error));
        }, 120000);
    </script>

    @stack('scripts')
</body>
</html>

<style>
.admin-nav-link {
    @apply text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-200;
}

.admin-nav-link.active {
    @apply bg-gray-900 text-white;
}

.admin-nav-button {
    @apply text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-200;
}

.admin-submenu-link {
    @apply text-gray-400 hover:text-gray-300 block px-2 py-1 text-sm rounded-md transition-colors duration-200;
}

.admin-submenu-link.active {
    @apply text-white bg-gray-700;
}
</style>