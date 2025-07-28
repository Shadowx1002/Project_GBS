@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container-custom">
        <!-- Header -->
        <div class="text-center mb-8" data-aos="fade-up">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Shopping Cart</h1>
            <p class="text-gray-600">
                {{ $cartItems->sum('quantity') }} {{ Str::plural('item', $cartItems->sum('quantity')) }} in your cart
            </p>
        </div>

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="card p-6" data-aos="fade-right">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Cart Items</h2>
                        
                        <div class="space-y-6">
                            @foreach($cartItems as $item)
                                <div class="flex flex-col sm:flex-row gap-4 p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0">
                                        <img src="{{ $item->product->primary_image_url }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="w-24 h-24 object-cover rounded-lg">
                                    </div>

                                    <!-- Product Details -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-lg font-medium text-gray-900">
                                                    <a href="{{ route('products.show', $item->product->slug) }}" 
                                                       class="hover:text-primary-600 transition-colors">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </h3>
                                                <p class="text-sm text-gray-500 mt-1">{{ $item->product->category->name }}</p>
                                                @if($item->product->brand)
                                                    <p class="text-sm text-gray-500">Brand: {{ $item->product->brand }}</p>
                                                @endif
                                                <p class="text-sm text-gray-500">SKU: {{ $item->product->sku }}</p>
                                            </div>
                                            
                                            <!-- Remove Button -->
                                            <form method="POST" action="{{ route('cart.remove', $item) }}" class="ml-4">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-500 hover:text-red-700 transition-colors p-1"
                                                        onclick="return confirm('Remove this item from cart?')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Price and Quantity -->
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-4">
                                            <div class="flex items-center space-x-4">
                                                <!-- Quantity Controls -->
                                                <div class="quantity-selector">
                                                    <form method="POST" action="{{ route('cart.update', $item) }}" class="flex">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="button" 
                                                                onclick="decrementQuantity({{ $item->id }})"
                                                                class="quantity-btn">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                            </svg>
                                                        </button>
                                                        <input type="number" 
                                                               name="quantity" 
                                                               value="{{ $item->quantity }}" 
                                                               min="1" 
                                                               max="10"
                                                               class="quantity-input"
                                                               onchange="updateQuantity({{ $item->id }}, this.value)">
                                                        <button type="button" 
                                                                onclick="incrementQuantity({{ $item->id }})"
                                                                class="quantity-btn">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>

                                                <!-- Stock Warning -->
                                                @if($item->product->stock_quantity <= 5)
                                                    <span class="text-xs text-orange-600 font-medium">
                                                        Only {{ $item->product->stock_quantity }} left in stock
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Price -->
                                            <div class="mt-2 sm:mt-0 text-right">
                                                <div class="text-lg font-semibold text-gray-900">
                                                    ${{ number_format($item->total_price, 2) }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    ${{ number_format($item->price, 2) }} each
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Availability Check -->
                                        @if(!$item->isProductAvailable())
                                            <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                                                <p class="text-sm text-red-700">
                                                    <strong>Product Unavailable:</strong> This item is no longer available for purchase.
                                                </p>
                                            </div>
                                        @elseif(!$item->canFulfillQuantity())
                                            <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                                <p class="text-sm text-yellow-700">
                                                    <strong>Insufficient Stock:</strong> Only {{ $item->product->stock_quantity }} available.
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Cart Actions -->
                        <div class="flex flex-col sm:flex-row justify-between items-center mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('products.index') }}" class="btn-outline mb-4 sm:mb-0">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Continue Shopping
                            </a>
                            
                            <form method="POST" action="{{ route('cart.clear') }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-700 transition-colors text-sm"
                                        onclick="return confirm('Clear all items from cart?')">
                                    Clear Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="card p-6 sticky top-24" data-aos="fade-left">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Summary</h2>
                        
                        <div class="space-y-4">
                            <!-- Subtotal -->
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                                <span class="font-medium">${{ number_format($subtotal, 2) }}</span>
                            </div>

                            <!-- Shipping -->
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-medium">
                                    @if($shippingAmount > 0)
                                        ${{ number_format($shippingAmount, 2) }}
                                    @else
                                        <span class="text-green-600">FREE</span>
                                    @endif
                                </span>
                            </div>

                            @if($subtotal < 100 && $shippingAmount > 0)
                                <div class="text-sm text-blue-600 bg-blue-50 p-3 rounded-lg">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Add ${{ number_format(100 - $subtotal, 2) }} more for free shipping!
                                </div>
                            @endif

                            <!-- Tax -->
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax (8%)</span>
                                <span class="font-medium">${{ number_format($taxAmount, 2) }}</span>
                            </div>

                            <hr class="border-gray-200">

                            <!-- Total -->
                            <div class="flex justify-between text-lg font-semibold">
                                <span>Total</span>
                                <span class="text-primary-600">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <div class="mt-8">
                            @if($cartItems->every(fn($item) => $item->isProductAvailable() && $item->canFulfillQuantity()))
                                <a href="{{ route('checkout.index') }}" class="w-full btn-primary text-center">
                                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Proceed to Checkout
                                </a>
                            @else
                                <button disabled class="w-full bg-gray-400 text-white px-6 py-3 rounded-lg cursor-not-allowed">
                                    Unable to Checkout - Please Review Items
                                </button>
                            @endif
                        </div>

                        <!-- Security Notice -->
                        <div class="mt-6 text-center">
                            <div class="flex items-center justify-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Secure SSL Checkout
                            </div>
                        </div>

                        <!-- Payment Methods -->
                        <div class="mt-6 text-center">
                            <p class="text-sm text-gray-500 mb-3">We Accept</p>
                            <div class="flex justify-center space-x-2">
                                <div class="w-10 h-6 bg-blue-600 rounded text-white text-xs flex items-center justify-center font-bold">VISA</div>
                                <div class="w-10 h-6 bg-red-600 rounded text-white text-xs flex items-center justify-center font-bold">MC</div>
                                <div class="w-10 h-6 bg-blue-500 rounded text-white text-xs flex items-center justify-center font-bold">AMEX</div>
                                <div class="w-10 h-6 bg-yellow-500 rounded text-white text-xs flex items-center justify-center font-bold">PP</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-16" data-aos="fade-up">
                <svg class="w-24 h-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5M17 13l2.5 5"></path>
                </svg>
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Your cart is empty</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Looks like you haven't added any items to your cart yet. Start exploring our amazing gel blaster collection!
                </p>
                <a href="{{ route('products.index') }}" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
// Quantity management functions
async function updateQuantity(itemId, quantity) {
    if (quantity < 1 || quantity > 10) return;
    
    try {
        const response = await fetch(`/cart/${itemId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ quantity: quantity })
        });

        if (response.ok) {
            location.reload(); // Reload to update totals
        } else {
            const data = await response.json();
            alert(data.message || 'Error updating quantity');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error updating quantity');
    }
}

function incrementQuantity(itemId) {
    const input = document.querySelector(`input[name="quantity"]`);
    const currentValue = parseInt(input.value);
    if (currentValue < 10) {
        updateQuantity(itemId, currentValue + 1);
    }
}

function decrementQuantity(itemId) {
    const input = document.querySelector(`input[name="quantity"]`);
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        updateQuantity(itemId, currentValue - 1);
    }
}

// Auto-update quantity on input change
document.addEventListener('DOMContentLoaded', function() {
    const quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const itemId = this.closest('form').querySelector('input[name="quantity"]').getAttribute('data-item-id');
            updateQuantity(itemId, this.value);
        });
    });
});

// Prevent form submission on enter for quantity inputs
document.addEventListener('DOMContentLoaded', function() {
    const quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(input => {
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.blur();
            }
        });
    });
});
</script>
@endpush
@endsection