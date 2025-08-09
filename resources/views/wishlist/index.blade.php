@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container-custom">
        <!-- Header -->
        <div class="text-center mb-8" data-aos="fade-up">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">My Wishlist</h1>
            <p class="text-gray-600">
                {{ $wishlistItems->count() }} {{ Str::plural('item', $wishlistItems->count()) }} saved for later
            </p>
        </div>

        @if($wishlistItems->count() > 0)
            <div class="product-grid">
                @foreach($wishlistItems as $item)
                    <div class="card-product" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="product-image-container relative">
                            <img src="{{ $item->product->primary_image_url }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="w-full h-64 object-cover transition-transform duration-300 hover:scale-110">
                            
                            @if($item->product->isOnSale())
                                <div class="discount-badge">
                                    -{{ $item->product->discount_percentage }}%
                                </div>
                            @endif

                            <!-- Remove from Wishlist -->
                            <button onclick="removeFromWishlist({{ $item->product->id }})" 
                                    class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="p-6">
                            <div class="mb-2">
                                <span class="text-sm text-primary-600 font-medium">{{ $item->product->category->name }}</span>
                            </div>
                            
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                <a href="{{ route('products.show', $item->product->slug) }}" class="hover:text-primary-600 transition-colors">
                                    {{ $item->product->name }}
                                </a>
                            </h3>
                            
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit($item->product->description, 100) }}</p>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    @if($item->product->isOnSale())
                                        <span class="price-sale">${{ $item->product->sale_price }}</span>
                                        <span class="price-original text-sm">${{ $item->product->price }}</span>
                                    @else
                                        <span class="price-current">${{ $item->product->price }}</span>
                                    @endif
                                </div>
                                
                                @if($item->product->canPurchase())
                                    <button onclick="addToCart({{ $item->product->id }})" 
                                            class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors">
                                        Add to Cart
                                    </button>
                                @else
                                    <span class="text-red-500 text-sm font-medium">Out of Stock</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty Wishlist -->
            <div class="text-center py-16" data-aos="fade-up">
                <svg class="w-24 h-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Your wishlist is empty</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Save items you love for later by clicking the heart icon on any product.
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
async function removeFromWishlist(productId) {
    try {
        const response = await fetch('/wishlist/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                product_id: productId
            })
        });

        const data = await response.json();

        if (data.success) {
            location.reload();
        } else {
            showNotification(data.message || 'Error removing from wishlist', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Error removing from wishlist', 'error');
    }
}

async function addToCart(productId, quantity = 1) {
    try {
        const response = await fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        });

        const data = await response.json();

        if (data.success) {
            updateCartCount();
            showNotification('Product added to cart!', 'success');
        } else {
            showNotification(data.message || 'Error adding product to cart', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Error adding product to cart', 'error');
    }
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-20 right-4 z-50 max-w-sm p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
    
    if (type === 'success') {
        notification.classList.add('bg-green-100', 'border', 'border-green-400', 'text-green-700');
    } else {
        notification.classList.add('bg-red-100', 'border', 'border-red-400', 'text-red-700');
    }
    
    notification.innerHTML = `
        <div class="flex justify-between items-center">
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-gray-500 hover:text-gray-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 5000);
}

function updateCartCount() {
    fetch('/cart/count')
        .then(response => response.json())
        .then(data => {
            const cartCountElement = document.getElementById('cart-count');
            if (cartCountElement) {
                cartCountElement.textContent = data.count;
            }
        })
        .catch(error => console.error('Error updating cart count:', error));
}
</script>
@endpush
@endsection