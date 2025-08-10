@extends('layouts.app')

@section('title', 'Manage Products')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <!-- Enhanced Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        Product Management
                    </h1>
                    <p class="text-gray-600 mt-2">Manage your product catalog and inventory</p>
                    <div class="flex items-center mt-2 space-x-4 text-sm text-gray-500">
                        <span>{{ $products->total() }} total products</span>
                        <span>•</span>
                        <span>{{ \App\Models\Product::where('status', 'active')->count() }} active</span>
                        <span>•</span>
                        <span>{{ \App\Models\Product::where('in_stock', false)->count() }} out of stock</span>
                    </div>
                </div>
                <div class="mt-6 lg:mt-0 flex flex-col sm:flex-row gap-3">
                    <button onclick="exportProducts()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export CSV
                    </button>
                    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl font-semibold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add New Product
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Enhanced Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8" data-aos="fade-up">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Filters & Search</h2>
                <button onclick="resetFilters()" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                    Reset All
                </button>
            </div>
            
            <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Enhanced Search -->
                <div class="lg:col-span-2">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               placeholder="Search products, SKU, or brand..." 
                               value="{{ request('search') }}"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Category Filter -->
                <div>
                    <select name="category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>✅ Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>❌ Inactive</option>
                    </select>
                </div>

                <!-- Stock Status Filter -->
                <div>
                    <select name="stock_status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        <option value="">All Stock Levels</option>
                        <option value="in_stock" {{ request('stock_status') === 'in_stock' ? 'selected' : '' }}>📦 In Stock</option>
                        <option value="out_of_stock" {{ request('stock_status') === 'out_of_stock' ? 'selected' : '' }}>❌ Out of Stock</option>
                        <option value="low_stock" {{ request('stock_status') === 'low_stock' ? 'selected' : '' }}>⚠️ Low Stock (≤10)</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="lg:col-span-5 md:col-span-2">
                    <button type="submit" class="w-full md:w-auto bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200 font-semibold">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Products Grid/Table Toggle -->
        <div class="flex items-center justify-between mb-6" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center space-x-4">
                <div class="flex bg-gray-100 rounded-lg p-1">
                    <button onclick="switchView('grid')" id="grid-view-btn" class="px-3 py-2 rounded-md text-sm font-medium transition-colors bg-white text-gray-900 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                    </button>
                    <button onclick="switchView('table')" id="table-view-btn" class="px-3 py-2 rounded-md text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="text-sm text-gray-600">
                    Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <select onchange="changeSort(this.value)" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="created_at-desc" {{ request('sort') === 'created_at' && request('order') === 'desc' ? 'selected' : '' }}>Newest First</option>
                    <option value="created_at-asc" {{ request('sort') === 'created_at' && request('order') === 'asc' ? 'selected' : '' }}>Oldest First</option>
                    <option value="name-asc" {{ request('sort') === 'name' && request('order') === 'asc' ? 'selected' : '' }}>Name A-Z</option>
                    <option value="name-desc" {{ request('sort') === 'name' && request('order') === 'desc' ? 'selected' : '' }}>Name Z-A</option>
                    <option value="price-asc" {{ request('sort') === 'price' && request('order') === 'asc' ? 'selected' : '' }}>Price Low-High</option>
                    <option value="price-desc" {{ request('sort') === 'price' && request('order') === 'desc' ? 'selected' : '' }}>Price High-Low</option>
                </select>
            </div>
        </div>

        <!-- Products Grid View -->
        <div id="grid-view" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" data-aos="fade-up" data-aos-delay="200">
            @forelse($products as $product)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <!-- Product Image -->
                    <div class="relative aspect-square overflow-hidden">
                        <img src="{{ $product->primary_image_url }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover transition-transform duration-300 hover:scale-110">
                        
                        <!-- Status Badges -->
                        <div class="absolute top-2 left-2 flex flex-col space-y-1">
                            @if($product->status === 'active')
                                <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full font-medium">Active</span>
                            @else
                                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-medium">Inactive</span>
                            @endif
                            
                            @if($product->is_featured)
                                <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded-full font-medium">⭐ Featured</span>
                            @endif
                        </div>

                        <!-- Stock Badge -->
                        <div class="absolute top-2 right-2">
                            @if($product->stock_quantity <= 0)
                                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-medium">Out of Stock</span>
                            @elseif($product->stock_quantity <= 10)
                                <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded-full font-medium">Low Stock</span>
                            @else
                                <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full font-medium">{{ $product->stock_quantity }} in stock</span>
                            @endif
                        </div>

                        <!-- Quick Actions Overlay -->
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.products.show', $product) }}" 
                                   class="bg-white text-gray-900 p-2 rounded-lg hover:bg-gray-100 transition-colors"
                                   title="View Details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700 transition-colors"
                                   title="Edit Product">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('products.show', $product->slug) }}" 
                                   target="_blank"
                                   class="bg-purple-600 text-white p-2 rounded-lg hover:bg-purple-700 transition-colors"
                                   title="View on Site">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded">
                                {{ $product->category->name }}
                            </span>
                            @if($product->brand)
                                <span class="text-xs text-gray-500">{{ $product->brand }}</span>
                            @endif
                        </div>
                        
                        <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 hover:text-blue-600 transition-colors">
                            <a href="{{ route('admin.products.show', $product) }}">
                                {{ $product->name }}
                            </a>
                        </h3>
                        
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ Str::limit($product->description, 80) }}</p>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex flex-col">
                                @if($product->isOnSale())
                                    <span class="text-lg font-bold text-red-600">${{ $product->sale_price }}</span>
                                    <span class="text-sm text-gray-500 line-through">${{ $product->price }}</span>
                                @else
                                    <span class="text-lg font-bold text-gray-900">${{ $product->price }}</span>
                                @endif
                                <span class="text-xs text-gray-500">SKU: {{ $product->sku }}</span>
                            </div>
                            
                            <div class="flex items-center space-x-1">
                                <button onclick="toggleProductStatus({{ $product->id }}, '{{ $product->status }}')"
                                        class="p-2 text-gray-400 hover:text-blue-600 transition-colors"
                                        title="Toggle Status">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                    </svg>
                                </button>
                                
                                <div class="relative group">
                                    <button class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                        </svg>
                                    </button>
                                    
                                    <div class="absolute right-0 top-8 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
                                        <div class="py-1">
                                            <a href="{{ route('admin.products.edit', $product) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit Product
                                            </a>
                                            <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                </svg>
                                                View on Site
                                            </a>
                                            <button onclick="duplicateProduct({{ $product->id }})" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                </svg>
                                                Duplicate
                                            </button>
                                            <div class="border-t border-gray-100"></div>
                                            <button onclick="deleteProduct({{ $product->id }}, '{{ $product->name }}')" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No products found</h3>
                        <p class="text-gray-600 mb-6">
                            @if(request()->hasAny(['search', 'category', 'status', 'stock_status']))
                                Try adjusting your filters or search terms.
                            @else
                                Get started by adding your first product to the catalog.
                            @endif
                        </p>
                        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl font-semibold">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Your First Product
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Table View (Hidden by default) -->
        <div id="table-view" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" data-aos="fade-up" data-aos-delay="200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <input type="checkbox" id="select-all" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" name="selected_products[]" value="{{ $product->id }}" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img src="{{ $product->primary_image_url }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                            <div class="text-sm text-gray-500">SKU: {{ $product->sku }}</div>
                                            @if($product->brand)
                                                <div class="text-xs text-gray-400">{{ $product->brand }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $product->category->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        @if($product->isOnSale())
                                            <span class="text-red-600 font-semibold">${{ $product->sale_price }}</span>
                                            <span class="text-gray-500 line-through text-sm">${{ $product->price }}</span>
                                        @else
                                            <span class="font-semibold">${{ $product->price }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->manage_stock)
                                        <div class="flex flex-col">
                                            <span class="font-medium {{ $product->stock_quantity <= 10 ? 'text-red-600' : 'text-green-600' }}">
                                                {{ $product->stock_quantity }}
                                            </span>
                                            @if($product->stock_quantity <= 10 && $product->stock_quantity > 0)
                                                <span class="text-xs text-orange-600">Low Stock</span>
                                            @elseif($product->stock_quantity == 0)
                                                <span class="text-xs text-red-600">Out of Stock</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-500 text-sm">Not tracked</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col space-y-1">
                                        @if($product->status === 'active')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactive</span>
                                        @endif
                                        
                                        @if($product->is_featured)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Featured</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.products.show', $product) }}" 
                                           class="text-blue-600 hover:text-blue-900 transition-colors">View</a>
                                        <a href="{{ route('admin.products.edit', $product) }}" 
                                           class="text-green-600 hover:text-green-900 transition-colors">Edit</a>
                                        <button onclick="deleteProduct({{ $product->id }}, '{{ $product->name }}')" 
                                                class="text-red-600 hover:text-red-900 transition-colors">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="mt-8 flex items-center justify-between" data-aos="fade-up">
                <div class="text-sm text-gray-600">
                    Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
                </div>
                <div>
                    {{ $products->links() }}
                </div>
            </div>
        @endif

        <!-- Bulk Actions (for table view) -->
        <div id="bulk-actions" class="hidden fixed bottom-6 left-1/2 transform -translate-x-1/2 bg-white rounded-lg shadow-lg border border-gray-200 p-4">
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-700">
                    <span id="selected-count">0</span> products selected
                </span>
                <div class="flex space-x-2">
                    <button onclick="bulkAction('activate')" class="px-3 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors text-sm">
                        Activate
                    </button>
                    <button onclick="bulkAction('deactivate')" class="px-3 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 transition-colors text-sm">
                        Deactivate
                    </button>
                    <button onclick="bulkAction('delete')" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors text-sm">
                        Delete
                    </button>
                </div>
                <button onclick="clearSelection()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({
        duration: 600,
        once: true,
        offset: 50
    });

    // View switching
    function switchView(view) {
        const gridView = document.getElementById('grid-view');
        const tableView = document.getElementById('table-view');
        const gridBtn = document.getElementById('grid-view-btn');
        const tableBtn = document.getElementById('table-view-btn');
        
        if (view === 'grid') {
            gridView.classList.remove('hidden');
            tableView.classList.add('hidden');
            gridBtn.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
            gridBtn.classList.remove('text-gray-500');
            tableBtn.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
            tableBtn.classList.add('text-gray-500');
        } else {
            gridView.classList.add('hidden');
            tableView.classList.remove('hidden');
            tableBtn.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
            tableBtn.classList.remove('text-gray-500');
            gridBtn.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
            gridBtn.classList.add('text-gray-500');
        }
        
        localStorage.setItem('admin_products_view', view);
    }

    // Load saved view preference
    document.addEventListener('DOMContentLoaded', function() {
        const savedView = localStorage.getItem('admin_products_view') || 'grid';
        switchView(savedView);
    });

    // Enhanced search with debouncing
    let searchTimeout;
    document.querySelector('input[name="search"]').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            if (this.value.length >= 3 || this.value.length === 0) {
                this.form.submit();
            }
        }, 500);
    });

    // Sort functionality
    function changeSort(value) {
        const [sort, order] = value.split('-');
        const url = new URL(window.location);
        url.searchParams.set('sort', sort);
        url.searchParams.set('order', order);
        window.location = url.toString();
    }

    // Reset filters
    function resetFilters() {
        window.location = '{{ route("admin.products.index") }}';
    }

    // Export functionality
    function exportProducts() {
        const params = new URLSearchParams(window.location.search);
        params.set('export', 'csv');
        
        const exportUrl = '{{ route("admin.products.index") }}?' + params.toString();
        window.open(exportUrl, '_blank');
    }

    // Product actions
    function toggleProductStatus(productId, currentStatus) {
        const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
        
        fetch(`/admin/products/${productId}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Error updating product status', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error updating product status', 'error');
        });
    }

    function deleteProduct(productId, productName) {
        if (confirm(`Are you sure you want to delete "${productName}"? This action cannot be undone.`)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/products/${productId}`;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }

    function duplicateProduct(productId) {
        // This would create a copy of the product
        showNotification('Duplicate functionality coming soon!', 'info');
    }

    // Bulk actions for table view
    function updateBulkActionsVisibility() {
        const checkboxes = document.querySelectorAll('input[name="selected_products[]"]:checked');
        const bulkActions = document.getElementById('bulk-actions');
        const selectedCount = document.getElementById('selected-count');
        
        if (checkboxes.length > 0) {
            bulkActions.classList.remove('hidden');
            selectedCount.textContent = checkboxes.length;
        } else {
            bulkActions.classList.add('hidden');
        }
    }

    function bulkAction(action) {
        const checkboxes = document.querySelectorAll('input[name="selected_products[]"]:checked');
        const productIds = Array.from(checkboxes).map(cb => cb.value);
        
        if (productIds.length === 0) {
            showNotification('Please select products first', 'warning');
            return;
        }
        
        const confirmMessage = {
            activate: `Activate ${productIds.length} products?`,
            deactivate: `Deactivate ${productIds.length} products?`,
            delete: `Delete ${productIds.length} products? This cannot be undone.`
        };
        
        if (confirm(confirmMessage[action])) {
            fetch('/admin/products/bulk-update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_ids: productIds,
                    action: action
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification('Bulk operation failed', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Bulk operation failed', 'error');
            });
        }
    }

    function clearSelection() {
        document.querySelectorAll('input[name="selected_products[]"]').forEach(cb => {
            cb.checked = false;
        });
        document.getElementById('select-all').checked = false;
        updateBulkActionsVisibility();
    }

    // Select all functionality
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select-all');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('input[name="selected_products[]"]');
                checkboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
                updateBulkActionsVisibility();
            });
        }
        
        // Individual checkbox listeners
        document.querySelectorAll('input[name="selected_products[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActionsVisibility);
        });
    });

    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-20 right-4 z-50 max-w-sm p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
        
        const colors = {
            success: 'bg-green-100 border border-green-400 text-green-700',
            error: 'bg-red-100 border border-red-400 text-red-700',
            warning: 'bg-yellow-100 border border-yellow-400 text-yellow-700',
            info: 'bg-blue-100 border border-blue-400 text-blue-700'
        };
        
        notification.classList.add(...colors[type].split(' '));
        
        notification.innerHTML = `
            <div class="flex justify-between items-center">
                <span class="text-sm font-medium">${message}</span>
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
</script>
@endpush
@endsection