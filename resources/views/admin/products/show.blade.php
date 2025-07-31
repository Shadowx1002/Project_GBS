@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="container-custom py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                    <p class="text-gray-600 mt-1">SKU: {{ $product->sku }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="btn-outline">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        View on Site
                    </a>
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Product
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn-secondary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-custom py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Product Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Product Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Category</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $product->category->name }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Brand</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $product->brand ?: 'N/A' }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Weight</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $product->weight ? $product->weight . ' kg' : 'N/A' }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Firing Range</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $product->firing_range ?: 'N/A' }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Build Material</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $product->build_material ?: 'N/A' }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Views</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ number_format($product->views) }}</dd>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $product->description }}</dd>
                    </div>
                    
                    @if($product->specifications)
                        <div class="mt-6">
                            <dt class="text-sm font-medium text-gray-500">Specifications</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $product->specifications }}</dd>
                        </div>
                    @endif
                </div>

                <!-- Product Images -->
                @if($product->images->count() > 0)
                    <div class="card p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Product Images</h2>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($product->images as $image)
                                <div class="relative">
                                    <img src="{{ $image->image_url }}" 
                                         alt="{{ $image->alt_text }}" 
                                         class="w-full h-32 object-cover rounded-lg border">
                                    @if($image->is_primary)
                                        <div class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded">
                                            Primary
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Sales Data -->
                @if($product->orderItems->count() > 0)
                    <div class="card p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Sales Performance</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Total Sold</dt>
                                <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ $product->orderItems->sum('quantity') }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Revenue Generated</dt>
                                <dd class="mt-1 text-2xl font-semibold text-gray-900">${{ number_format($product->orderItems->sum('total_price'), 2) }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Average Order Value</dt>
                                <dd class="mt-1 text-2xl font-semibold text-gray-900">
                                    ${{ $product->orderItems->count() > 0 ? number_format($product->orderItems->avg('total_price'), 2) : '0.00' }}
                                </dd>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Status -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Status</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Product Status</span>
                            @if($product->status === 'active')
                                <span class="badge-success">Active</span>
                            @else
                                <span class="badge-danger">Inactive</span>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Featured</span>
                            @if($product->is_featured)
                                <span class="badge-info">Yes</span>
                            @else
                                <span class="badge-secondary">No</span>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Stock Status</span>
                            @if($product->in_stock)
                                <span class="badge-success">In Stock</span>
                            @else
                                <span class="badge-danger">Out of Stock</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Pricing</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Regular Price</span>
                            <span class="text-lg font-semibold text-gray-900">${{ number_format($product->price, 2) }}</span>
                        </div>
                        
                        @if($product->sale_price)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Sale Price</span>
                                <span class="text-lg font-semibold text-red-600">${{ number_format($product->sale_price, 2) }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Discount</span>
                                <span class="text-sm font-medium text-red-600">{{ $product->discount_percentage }}% OFF</span>
                            </div>
                        @endif
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Current Price</span>
                            <span class="text-xl font-bold text-primary-600">${{ number_format($product->current_price, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Inventory -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Inventory</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Stock Quantity</span>
                            <span class="text-lg font-semibold {{ $product->stock_quantity <= 10 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $product->stock_quantity }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Stock Management</span>
                            @if($product->manage_stock)
                                <span class="badge-success">Enabled</span>
                            @else
                                <span class="badge-secondary">Disabled</span>
                            @endif
                        </div>
                        
                        @if($product->stock_quantity <= 10 && $product->stock_quantity > 0)
                            <div class="bg-orange-50 border border-orange-200 rounded-lg p-3">
                                <p class="text-sm text-orange-800">
                                    <strong>Low Stock Warning:</strong> Only {{ $product->stock_quantity }} items remaining
                                </p>
                            </div>
                        @elseif($product->stock_quantity == 0)
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                <p class="text-sm text-red-800">
                                    <strong>Out of Stock:</strong> This product is currently unavailable
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Timestamps -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Timestamps</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $product->created_at->format('M j, Y \a\t g:i A') }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $product->updated_at->format('M j, Y \a\t g:i A') }}</dd>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection