@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container-custom">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">My Orders</h1>
        
        @if($orders->count() > 0)
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="card p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">{{ $order->order_number }}</h3>
                                <p class="text-gray-600">{{ $order->created_at->format('M j, Y') }}</p>
                                <span class="status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-semibold">${{ number_format($order->total_amount, 2) }}</p>
                                <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:text-blue-700">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            {{ $orders->links() }}
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No orders yet</h3>
                <p class="text-gray-600 mb-4">Start shopping to see your orders here</p>
                <a href="{{ route('products.index') }}" class="btn-primary">Start Shopping</a>
            </div>
        @endif
    </div>
</div>
@endsection