@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Page Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="container-custom py-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between" data-aos="fade-up">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        Search Results for "{{ $query }}"
                    </h1>
                    <p class="mt-2 text-gray-600">
                        {{ $products->total() }} {{ Str::plural('product', $products->total()) }} found
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-custom py-8">
        @if($products->count() > 0)
            <div class="product-grid" data-aos="fade-up">
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

                            <!-- Quick View Overlay -->
                            <div class="absolute inset-0 bg-black/50 opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <a href="{{ route('products.show', $product->slug) }}" 
                                   class="bg-white text-gray-900 px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition-colors text-sm">
                                    Quick View
                                </a>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="mb-2">
                                <span class="text-sm text-primary-600 font-medium">{{ $product->category->name }}</span>
                            </div>
                            
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                <a href="{{ route('products.show', $product->slug) }}" class="hover:text-primary-600 transition-colors">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit($product->description, 100) }}</p>
                            
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
                                    @if(auth()->user()->isEligibleToPurchase())
                                        @if($product->canPurchase())
                                            <button onclick="addToCart({{ $product->id }})" 
                                                    class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors text-sm">
                                                Add to Cart
                                            </button>
                                        @else
                                            <span class="text-red-500 text-sm font-medium">Out of Stock</span>
                                        @endif
                                    @else
                                        <a href="{{ route('verification.show') }}" 
                                           class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition-colors text-sm">
                                            Verify Age
                                        </a>
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
                {{ $products->appends(['q' => $query])->links() }}
            </div>
        @else
            <!-- No Products Found -->
            <div class="text-center py-16" data-aos="fade-up">
                <svg class="w-24 h-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">No products found</h3>
                <p class="text-gray-600 mb-6">
                    We couldn't find any products matching "{{ $query }}". Try adjusting your search terms.
                </p>
                <a href="{{ route('products.index') }}" class="btn-primary">
                    Browse All Products
                </a>
            </div>
        @endif
    </div>
</div>
@endsection