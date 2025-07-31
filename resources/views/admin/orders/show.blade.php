@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="container-custom py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Order {{ $order->order_number }}</h1>
                    <p class="text-gray-600 mt-1">{{ $order->shipping_full_name }} • {{ $order->created_at->format('M j, Y') }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.orders.index') }}" class="btn-secondary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-custom py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Items -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Items</h2>
                    
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                @if($item->product)
                                    <img src="{{ $item->product->primary_image_url }}" 
                                         alt="{{ $item->product_name }}" 
                                         class="w-16 h-16 object-cover rounded">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $item->product_name }}</h4>
                                    <p class="text-sm text-gray-500">SKU: {{ $item->product_sku }}</p>
                                    <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                                </div>
                                
                                <div class="text-right">
                                    <p class="font-medium">${{ number_format($item->total_price, 2) }}</p>
                                    <p class="text-sm text-gray-500">${{ number_format($item->unit_price, 2) }} each</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Shipping Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Customer Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $order->shipping_full_name }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $order->shipping_email }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $order->shipping_phone ?: 'N/A' }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</dd>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <dt class="text-sm font-medium text-gray-500">Shipping Address</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $order->shipping_address_line_1 }}
                            @if($order->shipping_address_line_2), {{ $order->shipping_address_line_2 }}@endif
                            <br>
                            {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}
                            <br>
                            {{ $order->shipping_country }}
                        </dd>
                    </div>
                    
                    @if($order->notes)
                        <div class="mt-6">
                            <dt class="text-sm font-medium text-gray-500">Order Notes</dt>
                            <dd class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $order->notes }}</dd>
                        </div>
                    @endif
                </div>

                <!-- Order Totals -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Summary</h2>
                    
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-medium">${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Shipping:</span>
                            <span class="font-medium">${{ number_format($order->shipping_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tax:</span>
                            <span class="font-medium">${{ number_format($order->tax_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-semibold border-t pt-2 mt-2">
                            <span>Total:</span>
                            <span class="text-primary-600">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Panel -->
            <div class="lg:col-span-1">
                <div class="card p-6 sticky top-24">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Status</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Current Status</span>
                            <span class="status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Payment Status</span>
                            @if($order->payment_status === 'paid')
                                <span class="badge-success">Paid</span>
                            @elseif($order->payment_status === 'pending')
                                <span class="badge-warning">Pending</span>
                            @else
                                <span class="badge-danger">{{ ucfirst($order->payment_status) }}</span>
                            @endif
                        </div>
                        
                        @if($order->tracking_number)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Tracking Number</span>
                                <span class="text-sm font-medium text-gray-900">{{ $order->tracking_number }}</span>
                            </div>
                        @endif
                        
                        @if($order->shipped_at)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Shipped At</span>
                                <span class="text-sm text-gray-900">{{ $order->shipped_at->format('M j, Y g:i A') }}</span>
                            </div>
                        @endif
                        
                        @if($order->delivered_at)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Delivered At</span>
                                <span class="text-sm text-gray-900">{{ $order->delivered_at->format('M j, Y g:i A') }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Update Status Form -->
                    @if(in_array($order->status, ['pending', 'processing', 'shipped']))
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Update Status</h3>
                            
                            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="space-y-4">
                                @csrf
                                @method('PATCH')
                                
                                <div>
                                    <label for="status" class="form-label">New Status</label>
                                    <select name="status" id="status" class="form-input" required>
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="tracking_number" class="form-label">Tracking Number</label>
                                    <input type="text" 
                                           name="tracking_number" 
                                           id="tracking_number"
                                           class="form-input" 
                                           value="{{ old('tracking_number', $order->tracking_number) }}"
                                           placeholder="Enter tracking number">
                                </div>
                                
                                <div>
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea name="notes" 
                                              id="notes"
                                              rows="3" 
                                              class="form-input" 
                                              placeholder="Add any notes...">{{ old('notes') }}</textarea>
                                </div>
                                
                                <button type="submit" class="w-full btn-primary">
                                    Update Order Status
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="space-y-2">
                            <a href="{{ route('admin.users.show', $order->user) }}" 
                               class="block text-blue-600 hover:text-blue-700 text-sm">
                                View Customer Profile
                            </a>
                            <button onclick="sendOrderEmail()" 
                                    class="block text-blue-600 hover:text-blue-700 text-sm">
                                Send Status Email
                            </button>
                            <button onclick="printOrder()" 
                                    class="block text-blue-600 hover:text-blue-700 text-sm">
                                Print Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function sendOrderEmail() {
    // This would integrate with email system
    alert('Order status email sent to customer!');
}

function printOrder() {
    window.print();
}
</script>
@endpush
@endsection