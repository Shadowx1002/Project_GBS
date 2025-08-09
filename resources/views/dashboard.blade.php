@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="container-custom py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}!</h1>
                    <p class="text-gray-600 mt-1">Manage your account and track your orders</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Member since</p>
                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->created_at->format('M j, Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-custom py-8">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Orders -->
            <div class="card p-6" data-aos="fade-up">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Orders</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ auth()->user()->orders->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Spent -->
            <div class="card p-6" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Spent</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            ${{ number_format(auth()->user()->orders->where('payment_status', 'paid')->sum('total_amount'), 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Cart Items -->
            <div class="card p-6" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5M17 13l2.5 5"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Cart Items</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ auth()->user()->cartItems->sum('quantity') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Orders -->
            <div class="card p-6" data-aos="fade-right">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Orders</h3>
                    <a href="{{ route('orders.index') }}" class="text-sm text-blue-600 hover:text-blue-700">View all</a>
                </div>
                
                @if(auth()->user()->orders->count() > 0)
                    <div class="space-y-4">
                        @foreach(auth()->user()->orders->take(5) as $order)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-sm font-medium text-gray-900">{{ $order->order_number }}</span>
                                        <span class="status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $order->created_at->format('M j, Y') }} • {{ $order->items->count() }} items
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">${{ number_format($order->total_amount, 2) }}</p>
                                    <a href="{{ route('orders.show', $order) }}" class="text-xs text-blue-600 hover:text-blue-700">View</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No orders yet</h3>
                        <p class="text-gray-600 mb-4">Start shopping to see your orders here</p>
                        <a href="{{ route('products.index') }}" class="btn-primary">
                            Start Shopping
                        </a>
                    </div>
                @endif
            </div>

            <!-- Account Actions -->
            <div class="card p-6" data-aos="fade-left">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Quick Actions</h3>
                
                <div class="space-y-4">
                    <!-- Profile -->
                    <a href="{{ route('profile.edit') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-900">Edit Profile</h4>
                            <p class="text-sm text-gray-500">Update your personal information</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>

                    <!-- Orders -->
                    <a href="{{ route('orders.index') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-900">Order History</h4>
                            <p class="text-sm text-gray-500">View all your orders and tracking</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5M17 13l2.5 5"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-900">Shopping Cart</h4>
                            <p class="text-sm text-gray-500">Review items in your cart</p>
                        </div>
                        <div class="ml-auto flex items-center">
                            @if(auth()->user()->cartItems->count() > 0)
                                <span class="bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center mr-2">
                                    {{ auth()->user()->cartItems->sum('quantity') }}
                                </span>
                            @endif
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </a>

                    <!-- Verification -->
                    
                </div>
            </div>
        </div>

        <!-- Quick Browse -->
        <div class="mt-8 card p-6" data-aos="fade-up">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Continue Shopping</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @foreach($globalCategories->take(4) as $category)
                    <a href="{{ route('products.index') }}?category={{ $category->slug }}" class="group">
                        <div class="bg-gray-50 rounded-lg p-6 text-center hover:bg-gray-100 transition-colors">
                            <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-primary-200 transition-colors">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h4 class="text-sm font-medium text-gray-900 group-hover:text-primary-600 transition-colors">
                                {{ $category->name }}
                            </h4>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection