@extends('layouts.app')

@section('title', 'All Products')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Page Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="container-custom py-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between" data-aos="fade-up">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        @if(request('category'))
                            {{ $categories->where('slug', request('category'))->first()->name ?? 'Products' }}
                        @elseif(request('search'))
                            Search Results for "{{ request('search') }}"
                        @else
                            All Products
                        @endif
                    </h1>
                    <p class="mt-2 text-gray-600">
                        {{ $products->total() }} {{ Str::plural('product', $products->total()) }} found
                    </p>
                </div>
                
                <!-- Sort Options -->
                <div class="mt-4 md:mt-0">
                    <form method="GET" class="flex items-center space-x-4">
                        <!-- Preserve existing filters -->
                        @foreach(request()->except(['sort', 'order']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        
                        <select name="sort" onchange="this.form.submit()" class="form-input py-2 text-sm">
                            <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Newest First</option>
                            <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name A-Z</option>
                            <option value="price" {{ request('sort') === 'price' && request('order') === 'asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price" {{ request('sort') === 'price' && request('order') === 'desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="popularity" {{ request('sort') === 'popularity' ? 'selected' : '' }}>Most Popular</option>
                        </select>
                        
                        @if(request('sort') === 'price')
                            <input type="hidden" name="order" value="{{ request('sort') === 'price' && request('order') === 'desc' ? 'asc' : 'desc' }}">
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container-custom py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:w-1/4">
                <div class="card p-6 sticky top-24" data-aos="fade-right">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Filters</h2>
                    
                    <form method="GET" id="filter-form">
                        <!-- Preserve search term -->
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        
                        <!-- Category Filter -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Categories</h3>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="category" value="" 
                                           {{ !request('category') ? 'checked' : '' }}
                                           onchange="this.form.submit()"
                                           class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">All Categories</span>
                                </label>
                                @foreach($categories as $category)
                                    <label class="flex items-center">
                                        <input type="radio" name="category" value="{{ $category->slug }}" 
                                               {{ request('category') === $category->slug ? 'checked' : '' }}
                                               onchange="this.form.submit()"
                                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300">
                                        <span class="ml-2 text-sm text-gray-700">{{ $category->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Brand Filter -->
                        @if($brands->count() > 0)
                            <div class="mb-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Brands</h3>
                                <div class="space-y-2 max-h-40 overflow-y-auto">
                                    @foreach($brands as $brand)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="brand[]" value="{{ $brand }}" 
                                                   {{ in_array($brand, (array) request('brand', [])) ? 'checked' : '' }}
                                                   onchange="this.form.submit()"
                                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                            <span class="ml-2 text-sm text-gray-700">{{ $brand }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Price Range Filter -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Price Range</h3>
                            <div class="space-y-3">
                                <div class="flex items-center space-x-2">
                                    <input type="number" name="min_price" placeholder="Min" 
                                           value="{{ request('min_price') }}"
                                           min="0" max="{{ $priceRange['max'] }}"
                                           class="form-input text-sm py-2">
                                    <span class="text-gray-500">-</span>
                                    <input type="number" name="max_price" placeholder="Max" 
                                           value="{{ request('max_price') }}"
                                           min="{{ $priceRange['min'] }}" max="{{ $priceRange['max'] }}"
                                           class="form-input text-sm py-2">
                                </div>
                                <button type="submit" class="w-full btn-primary text-sm py-2">
                                    Apply Price Filter
                                </button>
                            </div>
                            <div class="mt-3 text-xs text-gray-500">
                                Range: ${{ $priceRange['min'] }} - ${{ $priceRange['max'] }}
                            </div>
                        </div>

                        <!-- Clear Filters -->
                        @if(request()->hasAny(['category', 'brand', 'min_price', 'max_price']))
                            <div class="pt-4 border-t border-gray-200">
                                <a href="{{ route('products.index') }}" class="w-full btn-outline text-sm py-2 block text-center">
                                    Clear All Filters
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="lg:w-3/4">
                @if($products->count() > 0)
                    <div class="product-grid" data-aos="fade-left">
                        @foreach($products as $product)
                            <div class="card-product" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 50 }}">
                                <div class="product-image-container relative">
                                    <img src="{{ $product->primary_image_url }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-64 object-cover transition-transform duration-300 hover:scale-110">
                                    
                                    @if($product->isOnSale())
                                        <div class="discount-badge">
                                            -{{ $product->discount_percentage }}%
                                        </div>
                                    @endif

                                    @if($product->stock_quantity <= 5 && $product->stock_quantity > 0)
                                        <div class="absolute top-2 right-2 bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                            Only {{ $product->stock_quantity }} left
                                        </div>
                                    @endif

                                    @if($product->is_featured)
                                        <div class="absolute top-2 left-2 bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                            Featured
                                        </div>
                                    @endif

                                    <!-- Quick View Overlay -->
                                    <div class="absolute inset-0 bg-black/50 opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('products.show', $product->slug) }}" 
                                               class="bg-white text-gray-900 px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition-colors text-sm">
                                                Quick View
                                            </a>
                                            @auth
                                            @if($product->canPurchase())
                                                <button onclick="addToCart({{ $product->id }})" 
                                                        class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors text-sm">
                                                    Add to Cart
                                                </button>
                                            @endif
                                            @endauth
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6">
                                    <div class="mb-2">
                                        <span class="text-sm text-primary-600 font-medium">{{ $product->category->name }}</span>
                                        @if($product->brand)
                                            <span class="text-sm text-gray-500 ml-2">• {{ $product->brand }}</span>
                                        @endif
                                    </div>
                                    
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                        <a href="{{ route('products.show', $product->slug) }}" class="hover:text-primary-600 transition-colors">
                                            {{ $product->name }}
                                        </a>
                                    </h3>
                                    
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit($product->description, 100) }}</p>
                                    
                                    <!-- Product Specs -->
                                    @if($product->firing_range || $product->weight)
                                        <div class="text-xs text-gray-500 mb-4 space-y-1">
                                            @if($product->firing_range)
                                                <div class="flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                    </svg>
                                                    Range: {{ $product->firing_range }}
                                                </div>
                                            @endif
                                            @if($product->weight)
                                                <div class="flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16l3-3m-3 3l-3-3"></path>
                                                    </svg>
                                                    Weight: {{ $product->weight }}kg
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            @if($product->isOnSale())
                                                <span class="price-sale">${{ $product->sale_price }}</span>
                                                <span class="price-original text-sm">${{ $product->price }}</span>
                                            @else
                                                <span class="price-current">${{ $product->price }}</span>
                                            @endif
                                        </div>
                                        
                                        @auth
                                            @if($product->canPurchase())
                                                <button onclick="addToCart({{ $product->id }})" 
                                                        class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors text-sm">
                                                    Add to Cart
                                                </button>
                                            @else
                                                <span class="text-red-500 text-sm font-medium">Out of Stock</span>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" 
                                               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors text-sm">
                                                Login to Buy
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12" data-aos="fade-up">
                        {{ $products->links() }}
                    </div>
                @else
                    <!-- No Products Found -->
                    <div class="text-center py-16" data-aos="fade-up">
                        <svg class="w-24 h-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <h3 class="text-2xl font-semibold text-gray-900 mb-4">No products found</h3>
                        <p class="text-gray-600 mb-6">
                            @if(request()->hasAny(['search', 'category', 'brand', 'min_price', 'max_price']))
                                Try adjusting your search criteria or filters.
                            @else
                                We're currently updating our inventory. Check back soon!
                            @endif
                        </p>
                        @if(request()->hasAny(['search', 'category', 'brand', 'min_price', 'max_price']))
                            <a href="{{ route('products.index') }}" class="btn-primary">
                                View All Products
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Add to cart functionality
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
            // Update cart count
            updateCartCount();
            
            // Show success message
            showNotification('Product added to cart!', 'success');
        } else {
            showNotification(data.message || 'Error adding product to cart', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Error adding product to cart', 'error');
    }
}

// Show notification function
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
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 5000);
}

// Mobile filter toggle
function toggleMobileFilters() {
    const filtersEl = document.querySelector('.filters-sidebar');
    filtersEl.classList.toggle('hidden');
}

// Price range validation
document.querySelector('input[name="min_price"]').addEventListener('input', function() {
    const maxPriceInput = document.querySelector('input[name="max_price"]');
    if (maxPriceInput.value && parseFloat(this.value) > parseFloat(maxPriceInput.value)) {
        maxPriceInput.value = this.value;
    }
});

document.querySelector('input[name="max_price"]').addEventListener('input', function() {
    const minPriceInput = document.querySelector('input[name="min_price"]');
    if (minPriceInput.value && parseFloat(this.value) < parseFloat(minPriceInput.value)) {
        minPriceInput.value = this.value;
    }
});
</script>
@endpush
@endsection
 