@extends('layouts.app')

@section('title', 'Add New Product')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <!-- Header Section -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        Add New Product
                    </h1>
                    <p class="text-gray-600 mt-2">Create a new product for your catalog with detailed information</p>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-3">
                    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Products
                    </a>
                    <button type="button" onclick="previewProduct()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-purple-500 to-blue-600 hover:from-purple-600 hover:to-blue-700 transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Preview
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" id="product-form" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
                <!-- Main Content Area -->
                <div class="xl:col-span-3 space-y-8">
                    <!-- Basic Information Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" data-aos="fade-up">
                        <div class="bg-gradient-to-r from-blue-50 to-purple-50 px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                Basic Information
                            </h2>
                            <p class="text-gray-600 text-sm mt-1">Essential product details and descriptions</p>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            <!-- Product Name -->
                            <div class="group">
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Product Name <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           name="name" 
                                           id="name"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 ring-2 ring-red-200 @enderror"
                                           value="{{ old('name') }}"
                                           placeholder="Enter product name..."
                                           required>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Category and Brand Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="group">
                                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Category <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <select name="category_id" 
                                                id="category_id"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('category_id') border-red-500 ring-2 ring-red-200 @enderror"
                                                required>
                                            <option value="">Select a category...</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('category_id')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="group">
                                    <label for="brand" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Brand
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                               name="brand" 
                                               id="brand"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('brand') border-red-500 ring-2 ring-red-200 @enderror"
                                               value="{{ old('brand') }}"
                                               placeholder="Enter brand name...">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h4a1 1 0 011 1v5m-6 0V9a1 1 0 011-1h4a1 1 0 011 1v11"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('brand')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="group">
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Product Description <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <textarea name="description" 
                                              id="description"
                                              rows="5"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none @error('description') border-red-500 ring-2 ring-red-200 @enderror"
                                              placeholder="Describe your product in detail..."
                                              required>{{ old('description') }}</textarea>
                                    <div class="absolute bottom-3 right-3 text-xs text-gray-400" id="description-counter">
                                        0 characters
                                    </div>
                                </div>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Specifications -->
                            <div class="group">
                                <label for="specifications" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Technical Specifications
                                </label>
                                <div class="relative">
                                    <textarea name="specifications" 
                                              id="specifications"
                                              rows="4"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none @error('specifications') border-red-500 ring-2 ring-red-200 @enderror"
                                              placeholder="Technical details, features, dimensions, etc...">{{ old('specifications') }}</textarea>
                                </div>
                                @error('specifications')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                Pricing Information
                            </h2>
                            <p class="text-gray-600 text-sm mt-1">Set competitive pricing for your product</p>
                        </div>
                        
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="group">
                                    <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Regular Price <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-lg font-medium">$</span>
                                        </div>
                                        <input type="number" 
                                               name="price" 
                                               id="price"
                                               step="0.01"
                                               min="0"
                                               class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('price') border-red-500 ring-2 ring-red-200 @enderror"
                                               value="{{ old('price') }}"
                                               placeholder="0.00"
                                               required>
                                    </div>
                                    @error('price')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="group">
                                    <label for="sale_price" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Sale Price (Optional)
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-lg font-medium">$</span>
                                        </div>
                                        <input type="number" 
                                               name="sale_price" 
                                               id="sale_price"
                                               step="0.01"
                                               min="0"
                                               class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('sale_price') border-red-500 ring-2 ring-red-200 @enderror"
                                               value="{{ old('sale_price') }}"
                                               placeholder="0.00">
                                    </div>
                                    @error('sale_price')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Price Preview -->
                            <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200" id="price-preview" style="display: none;">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Customer will see:</span>
                                    <div class="flex items-center space-x-2" id="price-display">
                                        <!-- Dynamic price display -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Details Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                </div>
                                Product Details
                            </h2>
                            <p class="text-gray-600 text-sm mt-1">Additional product specifications and features</p>
                        </div>
                        
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="group">
                                    <label for="weight" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Weight (kg)
                                    </label>
                                    <div class="relative">
                                        <input type="number" 
                                               name="weight" 
                                               id="weight"
                                               step="0.01"
                                               min="0"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('weight') border-red-500 ring-2 ring-red-200 @enderror"
                                               value="{{ old('weight') }}"
                                               placeholder="0.00">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-400 text-sm">kg</span>
                                        </div>
                                    </div>
                                    @error('weight')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="group">
                                    <label for="firing_range" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Firing Range
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                               name="firing_range" 
                                               id="firing_range"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('firing_range') border-red-500 ring-2 ring-red-200 @enderror"
                                               value="{{ old('firing_range') }}"
                                               placeholder="e.g., 25-30m">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('firing_range')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="group md:col-span-2">
                                    <label for="build_material" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Build Material
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                               name="build_material" 
                                               id="build_material"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('build_material') border-red-500 ring-2 ring-red-200 @enderror"
                                               value="{{ old('build_material') }}"
                                               placeholder="e.g., Nylon + Metal, Polymer, etc.">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('build_material')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Images Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                        <div class="bg-gradient-to-r from-indigo-50 to-blue-50 px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                Product Images
                            </h2>
                            <p class="text-gray-600 text-sm mt-1">Upload high-quality images or provide URLs</p>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            <!-- File Upload Area -->
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    Upload Images
                                </label>
                                <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-400 transition-colors group-hover:border-blue-400" id="upload-area">
                                    <input type="file" 
                                           name="images[]" 
                                           id="images"
                                           multiple
                                           accept="image/*"
                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    
                                    <div class="space-y-4">
                                        <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full flex items-center justify-center mx-auto">
                                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-lg font-medium text-gray-900">Drop images here or click to browse</p>
                                            <p class="text-sm text-gray-500 mt-1">PNG, JPG, JPEG up to 5MB each</p>
                                        </div>
                                        <div class="flex items-center justify-center space-x-2 text-xs text-gray-400">
                                            <span>Supports multiple files</span>
                                            <span>•</span>
                                            <span>Drag & drop enabled</span>
                                        </div>
                                    </div>
                                </div>
                                @error('images.*')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Image Preview Area -->
                            <div id="image-preview" class="hidden">
                                <h3 class="text-sm font-semibold text-gray-700 mb-3">Selected Images</h3>
                                <div id="preview-grid" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <!-- Preview images will be inserted here -->
                                </div>
                            </div>

                            <!-- URL Input Alternative -->
                            <div class="relative">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-4 bg-white text-gray-500 font-medium">OR</span>
                                </div>
                            </div>

                            <div class="group">
                                <label for="image_urls" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Image URLs (One per line)
                                </label>
                                <div class="relative">
                                    <textarea name="image_urls" 
                                              id="image_urls"
                                              rows="4"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none @error('image_urls') border-red-500 ring-2 ring-red-200 @enderror"
                                              placeholder="https://example.com/image1.jpg&#10;https://example.com/image2.jpg&#10;https://example.com/image3.jpg">{{ old('image_urls') }}</textarea>
                                    <div class="absolute bottom-3 right-3">
                                        <button type="button" onclick="validateUrls()" class="text-xs text-blue-600 hover:text-blue-700 font-medium">
                                            Validate URLs
                                        </button>
                                    </div>
                                </div>
                                @error('image_urls')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="xl:col-span-1 space-y-6">
                    <!-- Inventory Management -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-24" data-aos="fade-left">
                        <div class="bg-gradient-to-r from-orange-50 to-red-50 px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                <div class="w-7 h-7 bg-gradient-to-br from-orange-500 to-red-600 rounded-lg flex items-center justify-center mr-2">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                </div>
                                Inventory
                            </h2>
                        </div>
                        
                        <div class="p-6 space-y-4">
                            <div class="group">
                                <label for="sku" class="block text-sm font-semibold text-gray-700 mb-2">
                                    SKU
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           name="sku" 
                                           id="sku"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('sku') border-red-500 ring-2 ring-red-200 @enderror"
                                           value="{{ old('sku') }}"
                                           placeholder="Auto-generated">
                                    <button type="button" onclick="generateSKU()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-blue-600 hover:text-blue-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                    </button>
                                </div>
                                @error('sku')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="group">
                                <label for="stock_quantity" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Stock Quantity <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           name="stock_quantity" 
                                           id="stock_quantity"
                                           min="0"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('stock_quantity') border-red-500 ring-2 ring-red-200 @enderror"
                                           value="{{ old('stock_quantity', 0) }}"
                                           required>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-400 text-sm">units</span>
                                    </div>
                                </div>
                                @error('stock_quantity')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="flex items-center p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <input type="checkbox" 
                                       name="manage_stock" 
                                       id="manage_stock"
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                       {{ old('manage_stock', true) ? 'checked' : '' }}>
                                <label for="manage_stock" class="ml-3 text-sm font-medium text-gray-700">
                                    Track stock quantity automatically
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Product Status -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" data-aos="fade-left" data-aos-delay="100">
                        <div class="bg-gradient-to-r from-green-50 to-teal-50 px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                <div class="w-7 h-7 bg-gradient-to-br from-green-500 to-teal-600 rounded-lg flex items-center justify-center mr-2">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                Status & Visibility
                            </h2>
                        </div>
                        
                        <div class="p-6 space-y-4">
                            <div class="group">
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Product Status <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="status" 
                                            id="status"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('status') border-red-500 ring-2 ring-red-200 @enderror"
                                            required>
                                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>
                                            ✅ Active (Visible to customers)
                                        </option>
                                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>
                                            ❌ Inactive (Hidden from customers)
                                        </option>
                                    </select>
                                </div>
                                @error('status')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="flex items-center p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                                <input type="checkbox" 
                                       name="is_featured" 
                                       id="is_featured"
                                       class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded"
                                       {{ old('is_featured') ? 'checked' : '' }}>
                                <label for="is_featured" class="ml-3 text-sm font-medium text-gray-700">
                                    ⭐ Featured product (Show on homepage)
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" data-aos="fade-left" data-aos-delay="200">
                        <div class="p-6 space-y-4">
                            <button type="submit" 
                                    id="submit-btn"
                                    class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-4 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl font-semibold text-lg flex items-center justify-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span id="submit-text">Create Product</span>
                                <div id="submit-loading" class="hidden flex items-center">
                                    <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin mr-2"></div>
                                    Creating...
                                </div>
                            </button>
                            
                            <button type="button" 
                                    onclick="saveDraft()"
                                    class="w-full bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 transition-colors font-medium flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Save as Draft
                            </button>
                            
                            <a href="{{ route('admin.products.index') }}" 
                               class="w-full bg-white border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition-colors font-medium flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </a>
                        </div>
                    </div>

                    <!-- Quick Tips -->
                    <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-xl border border-blue-200 p-6" data-aos="fade-left" data-aos-delay="300">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                            Quick Tips
                        </h3>
                        <div class="space-y-3 text-sm text-gray-600">
                            <div class="flex items-start">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                <p>Use high-quality images (at least 800x800px) for better customer experience</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-2 h-2 bg-purple-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                <p>Include detailed specifications to help customers make informed decisions</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-2 h-2 bg-green-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                <p>Set competitive pricing by researching similar products</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-2 h-2 bg-orange-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                <p>Use SEO-friendly product names and descriptions</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Preview Modal -->
<div id="preview-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Product Preview</h3>
                    <button onclick="closePreview()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="preview-content" class="max-h-96 overflow-y-auto">
                    <!-- Preview content will be inserted here -->
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- AOS Animation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({
        duration: 600,
        once: true,
        offset: 50
    });
</script>

<script>
// Form validation and enhancement
document.addEventListener('DOMContentLoaded', function() {
    initializeFormEnhancements();
    setupImageHandling();
    setupPriceCalculation();
    setupFormValidation();
});

function initializeFormEnhancements() {
    // Character counter for description
    const descriptionField = document.getElementById('description');
    const counter = document.getElementById('description-counter');
    
    descriptionField.addEventListener('input', function() {
        const length = this.value.length;
        counter.textContent = `${length} characters`;
        
        if (length > 500) {
            counter.classList.add('text-red-500');
            counter.classList.remove('text-gray-400');
        } else {
            counter.classList.remove('text-red-500');
            counter.classList.add('text-gray-400');
        }
    });

    // Auto-generate SKU from product name
    document.getElementById('name').addEventListener('input', function() {
        const skuField = document.getElementById('sku');
        if (!skuField.value || skuField.placeholder === 'Auto-generated') {
            const name = this.value.replace(/[^a-zA-Z0-9]/g, '').toUpperCase().substring(0, 8);
            if (name) {
                skuField.placeholder = `GB-${name}-${Math.random().toString(36).substr(2, 4).toUpperCase()}`;
            }
        }
    });
}

function setupImageHandling() {
    const uploadArea = document.getElementById('upload-area');
    const fileInput = document.getElementById('images');
    const previewArea = document.getElementById('image-preview');
    const previewGrid = document.getElementById('preview-grid');

    // Drag and drop functionality
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('border-blue-500', 'bg-blue-50');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('border-blue-500', 'bg-blue-50');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('border-blue-500', 'bg-blue-50');
        
        const files = e.dataTransfer.files;
        handleFiles(files);
    });

    fileInput.addEventListener('change', function(e) {
        handleFiles(e.target.files);
    });

    function handleFiles(files) {
        previewGrid.innerHTML = '';
        
        if (files.length > 0) {
            previewArea.classList.remove('hidden');
            
            Array.from(files).forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = createImagePreview(e.target.result, file.name, index);
                        previewGrid.appendChild(preview);
                    };
                    reader.readAsDataURL(file);
                }
            });
        } else {
            previewArea.classList.add('hidden');
        }
    }

    function createImagePreview(src, name, index) {
        const div = document.createElement('div');
        div.className = 'relative group';
        div.innerHTML = `
            <img src="${src}" class="w-full h-24 object-cover rounded-lg border border-gray-200 group-hover:border-blue-500 transition-colors">
            <div class="absolute top-1 left-1 bg-blue-500 text-white text-xs px-2 py-1 rounded">
                ${index === 0 ? 'Primary' : index + 1}
            </div>
            <div class="absolute top-1 right-1 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                ${name.length > 15 ? name.substring(0, 15) + '...' : name}
            </div>
            <button type="button" onclick="removeImagePreview(this)" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;
        return div;
    }
}

function removeImagePreview(button) {
    button.closest('.relative').remove();
    
    // Check if any previews remain
    const previewGrid = document.getElementById('preview-grid');
    if (previewGrid.children.length === 0) {
        document.getElementById('image-preview').classList.add('hidden');
    }
}

function setupPriceCalculation() {
    const priceField = document.getElementById('price');
    const salePriceField = document.getElementById('sale_price');
    const pricePreview = document.getElementById('price-preview');
    const priceDisplay = document.getElementById('price-display');

    function updatePricePreview() {
        const price = parseFloat(priceField.value) || 0;
        const salePrice = parseFloat(salePriceField.value) || 0;

        if (price > 0) {
            pricePreview.style.display = 'block';
            
            if (salePrice > 0 && salePrice < price) {
                const discount = Math.round(((price - salePrice) / price) * 100);
                priceDisplay.innerHTML = `
                    <span class="text-lg font-bold text-red-600">$${salePrice.toFixed(2)}</span>
                    <span class="text-sm text-gray-500 line-through">$${price.toFixed(2)}</span>
                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">${discount}% OFF</span>
                `;
            } else {
                priceDisplay.innerHTML = `<span class="text-lg font-bold text-gray-900">$${price.toFixed(2)}</span>`;
            }
        } else {
            pricePreview.style.display = 'none';
        }
    }

    priceField.addEventListener('input', updatePricePreview);
    salePriceField.addEventListener('input', updatePricePreview);

    // Sale price validation
    salePriceField.addEventListener('blur', function() {
        const price = parseFloat(priceField.value) || 0;
        const salePrice = parseFloat(this.value) || 0;
        
        if (salePrice > 0 && salePrice >= price) {
            this.setCustomValidity('Sale price must be less than regular price');
            this.classList.add('border-red-500');
        } else {
            this.setCustomValidity('');
            this.classList.remove('border-red-500');
        }
    });
}

function setupFormValidation() {
    const form = document.getElementById('product-form');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (validateForm()) {
            showLoadingState();
            this.submit();
        }
    });

    // Real-time validation
    const requiredFields = ['name', 'category_id', 'description', 'price', 'stock_quantity', 'status'];
    
    requiredFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.addEventListener('blur', function() {
                validateField(this);
            });
        }
    });
}

function validateField(field) {
    const value = field.value.trim();
    const isRequired = field.hasAttribute('required');
    
    if (isRequired && !value) {
        field.classList.add('border-red-500', 'ring-2', 'ring-red-200');
        field.classList.remove('border-green-500', 'ring-green-200');
        return false;
    } else if (value) {
        field.classList.add('border-green-500', 'ring-2', 'ring-green-200');
        field.classList.remove('border-red-500', 'ring-red-200');
        return true;
    } else {
        field.classList.remove('border-red-500', 'ring-red-200', 'border-green-500', 'ring-green-200');
        return true;
    }
}

function validateForm() {
    const requiredFields = ['name', 'category_id', 'description', 'price', 'stock_quantity', 'status'];
    let isValid = true;
    
    requiredFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field && !validateField(field)) {
            isValid = false;
        }
    });
    
    if (!isValid) {
        showNotification('Please fill in all required fields', 'error');
        // Scroll to first error
        const firstError = document.querySelector('.border-red-500');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
    }
    
    return isValid;
}

function showLoadingState() {
    const submitBtn = document.getElementById('submit-btn');
    const submitText = document.getElementById('submit-text');
    const submitLoading = document.getElementById('submit-loading');
    
    submitBtn.disabled = true;
    submitText.classList.add('hidden');
    submitLoading.classList.remove('hidden');
    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
}

function generateSKU() {
    const name = document.getElementById('name').value;
    const category = document.getElementById('category_id').selectedOptions[0]?.text || '';
    
    let sku = 'GB-';
    
    if (name) {
        sku += name.replace(/[^a-zA-Z0-9]/g, '').toUpperCase().substring(0, 4);
    }
    
    if (category) {
        sku += '-' + category.replace(/[^a-zA-Z0-9]/g, '').toUpperCase().substring(0, 3);
    }
    
    sku += '-' + Math.random().toString(36).substr(2, 4).toUpperCase();
    
    document.getElementById('sku').value = sku;
    
    // Show success animation
    const skuField = document.getElementById('sku');
    skuField.classList.add('ring-2', 'ring-green-500', 'border-green-500');
    setTimeout(() => {
        skuField.classList.remove('ring-2', 'ring-green-500', 'border-green-500');
    }, 2000);
}

function validateUrls() {
    const urlsText = document.getElementById('image_urls').value;
    const urls = urlsText.split('\n').filter(url => url.trim());
    
    let validCount = 0;
    let invalidUrls = [];
    
    urls.forEach(url => {
        const trimmedUrl = url.trim();
        if (trimmedUrl) {
            try {
                new URL(trimmedUrl);
                if (trimmedUrl.match(/\.(jpg|jpeg|png|gif|webp)$/i)) {
                    validCount++;
                } else {
                    invalidUrls.push(trimmedUrl + ' (not an image)');
                }
            } catch {
                invalidUrls.push(trimmedUrl + ' (invalid URL)');
            }
        }
    });
    
    if (invalidUrls.length > 0) {
        showNotification(`Found ${invalidUrls.length} invalid URLs. Check console for details.`, 'error');
        console.log('Invalid URLs:', invalidUrls);
    } else if (validCount > 0) {
        showNotification(`All ${validCount} URLs are valid!`, 'success');
    } else {
        showNotification('No URLs found to validate', 'warning');
    }
}

function previewProduct() {
    const formData = new FormData(document.getElementById('product-form'));
    const data = {};
    
    for (let [key, value] of formData.entries()) {
        if (key !== '_token') {
            data[key] = value;
        }
    }
    
    const previewContent = `
        <div class="bg-white rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="aspect-square bg-gray-100 rounded-lg flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">${data.name || 'Product Name'}</h2>
                    <p class="text-sm text-blue-600 mb-4">${document.getElementById('category_id').selectedOptions[0]?.text || 'Category'}</p>
                    <div class="mb-4">
                        ${data.sale_price && parseFloat(data.sale_price) > 0 ? 
                            `<span class="text-2xl font-bold text-red-600">$${parseFloat(data.sale_price).toFixed(2)}</span>
                             <span class="text-lg text-gray-500 line-through ml-2">$${parseFloat(data.price || 0).toFixed(2)}</span>` :
                            `<span class="text-2xl font-bold text-gray-900">$${parseFloat(data.price || 0).toFixed(2)}</span>`
                        }
                    </div>
                    <p class="text-gray-600 mb-4">${data.description || 'Product description will appear here...'}</p>
                    ${data.specifications ? `<div class="text-sm text-gray-500"><strong>Specs:</strong> ${data.specifications}</div>` : ''}
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('preview-content').innerHTML = previewContent;
    document.getElementById('preview-modal').classList.remove('hidden');
}

function closePreview() {
    document.getElementById('preview-modal').classList.add('hidden');
}

function saveDraft() {
    // Save form data to localStorage
    const formData = new FormData(document.getElementById('product-form'));
    const data = {};
    
    for (let [key, value] of formData.entries()) {
        if (key !== '_token') {
            data[key] = value;
        }
    }
    
    localStorage.setItem('product_draft', JSON.stringify(data));
    showNotification('Draft saved successfully!', 'success');
}

function loadDraft() {
    const draft = localStorage.getItem('product_draft');
    if (draft) {
        const data = JSON.parse(draft);
        
        Object.keys(data).forEach(key => {
            const field = document.querySelector(`[name="${key}"]`);
            if (field) {
                if (field.type === 'checkbox') {
                    field.checked = data[key] === 'on';
                } else {
                    field.value = data[key];
                }
            }
        });
        
        showNotification('Draft loaded!', 'info');
    }
}

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

// Load draft on page load if available
window.addEventListener('load', function() {
    if (localStorage.getItem('product_draft')) {
        const loadDraftConfirm = confirm('Found a saved draft. Would you like to load it?');
        if (loadDraftConfirm) {
            loadDraft();
        }
    }
});

// Clear draft on successful submission
document.getElementById('product-form').addEventListener('submit', function() {
    localStorage.removeItem('product_draft');
});

// Auto-save draft every 30 seconds
setInterval(function() {
    const name = document.getElementById('name').value;
    if (name.trim()) {
        saveDraft();
    }
}, 30000);

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + S to save draft
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        saveDraft();
    }
    
    // Ctrl/Cmd + Enter to submit form
    if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('product-form').dispatchEvent(new Event('submit'));
    }
    
    // Escape to close modal
    if (e.key === 'Escape') {
        closePreview();
    }
});

// Form progress tracking
function updateFormProgress() {
    const requiredFields = ['name', 'category_id', 'description', 'price', 'stock_quantity'];
    let filledFields = 0;
    
    requiredFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field && field.value.trim()) {
            filledFields++;
        }
    });
    
    const progress = (filledFields / requiredFields.length) * 100;
    
    // Update progress indicator if it exists
    const progressBar = document.getElementById('form-progress');
    if (progressBar) {
        progressBar.style.width = progress + '%';
    }
}

// Add progress tracking to all form fields
document.querySelectorAll('input, select, textarea').forEach(field => {
    field.addEventListener('input', updateFormProgress);
});
</script>
@endpush
@endsection