@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container-custom">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb" data-aos="fade-up">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700">Products</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-gray-500 hover:text-gray-700">{{ $product->category->name }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700 font-medium">{{ Str::limit($product->name, 30) }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Product Images -->
            <div class="space-y-4" data-aos="fade-right">
                <!-- Main Image -->
                <div class="aspect-square bg-white rounded-xl shadow-lg overflow-hidden">
                    @if($product->images->count() > 0)
                        <img id="main-image" 
                             src="{{ $product->primaryImage->image_url ?? $product->images->first()->image_url }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Thumbnail Images -->
                @if($product->images->count() > 1)
                    <div class="flex space-x-2 overflow-x-auto pb-2">
                        @foreach($product->images as $image)
                            <button onclick="changeMainImage('{{ $image->image_url }}')" 
                                    class="flex-shrink-0 w-20 h-20 bg-white rounded-lg overflow-hidden border-2 border-transparent hover:border-primary-500 transition-colors">
                                <img src="{{ $image->image_url }}" 
                                     alt="{{ $image->alt_text }}" 
                                     class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Information -->
            <div class="space-y-6" data-aos="fade-left">
                <!-- Product Title and Price -->
                <div>
                    <div class="flex items-center space-x-2 mb-2">
                        <span class="text-sm font-medium text-primary-600">{{ $product->category->name }}</span>
                        @if($product->brand)
                            <span class="text-sm text-gray-500">•</span>
                            <span class="text-sm text-gray-500">{{ $product->brand }}</span>
                        @endif
                    </div>
                    
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                    
                    <div class="flex items-center space-x-4 mb-4">
                        @if($product->isOnSale())
                            <span class="text-3xl font-bold text-red-600">${{ $product->sale_price }}</span>
                            <span class="text-xl text-gray-500 line-through">${{ $product->price }}</span>
                            <span class="bg-red-500 text-white text-sm font-bold px-2 py-1 rounded">
                                {{ $product->discount_percentage }}% OFF
                            </span>
                        @else
                            <span class="text-3xl font-bold text-gray-900">${{ $product->price }}</span>
                        @endif
                    </div>

                    <!-- Stock Status -->
                    <div class="mb-6">
                        @if($product->canPurchase())
                            @if($product->stock_quantity <= 5)
                                <div class="flex items-center text-orange-600">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.729-.833-2.5 0L4.732 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <span class="font-medium">Only {{ $product->stock_quantity }} left in stock!</span>
                                </div>
                            @else
                                <div class="flex items-center text-green-600">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="font-medium">In Stock</span>
                                </div>
                            @endif
                        @else
                            <div class="flex items-center text-red-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span class="font-medium">Out of Stock</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Add to Cart Section -->
                <div class="border-t border-gray-200 pt-6">
                    @auth
                        @if($product->canPurchase())
                            <div class="flex items-center space-x-4 mb-4">
                                <!-- Quantity Selector -->
                                <div class="flex items-center">
                                    <label for="quantity" class="text-sm font-medium text-gray-700 mr-3">Quantity:</label>
                                    <div class="quantity-selector">
                                        <button type="button" onclick="decrementQuantity()" class="quantity-btn">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        <input type="number" 
                                               id="quantity" 
                                               value="1" 
                                               min="1" 
                                    
                                    <button onclick="addToWishlist({{ $product->id }})" 
                                            class="btn-outline py-4 px-6">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                               max="10"
                                               class="quantity-input">
                                        <button type="button" onclick="incrementQuantity()" class="quantity-btn">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            @auth
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <button onclick="addToCartWithQuantity()" 
                                            class="flex-1 btn-primary text-lg py-4">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5M17 13l2.5 5"></path>
                                        </svg>
                                        Add to Cart
                                    </button>
                                    
                                    <button onclick="addToWishlist({{ $product->id }})" 
                                            class="btn-outline py-4 px-6">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endauth
                        @else
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                <p class="text-red-800 font-medium">This product is currently out of stock.</p>
                                <p class="text-red-600 text-sm mt-1">Check back later or contact us for availability updates.</p>
                            </div>
                        @endif
                    @else
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <p class="text-blue-800 font-medium">Please log in to purchase this product.</p>
                            <div class="flex space-x-3 mt-3">
                                <a href="{{ route('login') }}" class="btn-primary">Login</a>
                                <a href="{{ route('register') }}" class="btn-outline">Create Account</a>
                            </div>
                        </div>
                    @endauth
                </div>

                <!-- Product Details -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Details</h3>
                    <div class="prose prose-sm max-w-none text-gray-600">
                        {{ $product->description }}
                    </div>
                </div>

                <!-- Specifications -->
                @if($product->specifications || $product->firing_range || $product->weight || $product->build_material)
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Specifications</h3>
                        
                        @if($product->specifications)
                            <div class="prose prose-sm max-w-none text-gray-600 mb-4">
                                {{ $product->specifications }}
                            </div>
                        @endif
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($product->firing_range)
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600"><strong>Range:</strong> {{ $product->firing_range }}</span>
                                </div>
                            @endif
                            
                            @if($product->weight)
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16l3-3m-3 3l-3-3"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600"><strong>Weight:</strong> {{ $product->weight }}kg</span>
                                </div>
                            @endif
                            
                            @if($product->build_material)
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600"><strong>Material:</strong> {{ $product->build_material }}</span>
                                </div>
                            @endif
                            
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                <span class="text-sm text-gray-600"><strong>SKU:</strong> {{ $product->sku }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Safety Notice -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.729-.833-2.5 0L4.732 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Safety Information</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>Always wear appropriate protective gear. Use only in designated areas. Follow all local laws and regulations.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-16" data-aos="fade-up">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="card-product">
                            <div class="product-image-container relative">
                                <img src="{{ $relatedProduct->primary_image_url }}" 
                                     alt="{{ $relatedProduct->name }}" 
                                     class="w-full h-48 object-cover">
                                
                                @if($relatedProduct->isOnSale())
                                    <div class="discount-badge">
                                        -{{ $relatedProduct->discount_percentage }}%
                                    </div>
                                @endif
                            </div>

                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                    <a href="{{ route('products.show', $relatedProduct->slug) }}" class="hover:text-primary-600 transition-colors">
                                        {{ $relatedProduct->name }}
                                    </a>
                                </h3>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        @if($relatedProduct->isOnSale())
                                            <span class="text-lg font-bold text-red-600">${{ $relatedProduct->sale_price }}</span>
                                            <span class="text-sm text-gray-500 line-through">${{ $relatedProduct->price }}</span>
                                        @else
                                            <span class="text-lg font-bold text-gray-900">${{ $relatedProduct->price }}</span>
                                        @endif
                                    </div>
                                    
                                    <a href="{{ route('products.show', $relatedProduct->slug) }}" 
                                       class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function changeMainImage(imageUrl) {
    document.getElementById('main-image').src = imageUrl;
}

function incrementQuantity() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    if (currentValue < 10) {
        input.value = currentValue + 1;
    }
}

function decrementQuantity() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
    }
}

function addToCartWithQuantity() {
    const quantity = parseInt(document.getElementById('quantity').value);
    addToCart({{ $product->id }}, quantity);
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

async function addToWishlist(productId) {
    try {
        const response = await fetch('/wishlist/add', {
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
            showNotification('Product added to wishlist!', 'success');
        } else {
            showNotification(data.message || 'Error adding to wishlist', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Error adding to wishlist', 'error');
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