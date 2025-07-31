@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="container-custom py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Add New Product</h1>
                    <p class="text-gray-600 mt-1">Create a new product in your catalog</p>
                </div>
                <a href="{{ route('admin.products.index') }}" class="btn-outline">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Products
                </a>
            </div>
        </div>
    </div>

    <div class="container-custom py-8">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="max-w-4xl mx-auto">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Product Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="card p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Basic Information</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" 
                                       name="name" 
                                       id="name"
                                       class="form-input @error('name') border-red-500 @enderror"
                                       value="{{ old('name') }}"
                                       required>
                                @error('name')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category_id" class="form-label">Category</label>
                                <select name="category_id" 
                                        id="category_id"
                                        class="form-input @error('category_id') border-red-500 @enderror"
                                        required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" 
                                          id="description"
                                          rows="4"
                                          class="form-input @error('description') border-red-500 @enderror"
                                          required>{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="specifications" class="form-label">Specifications (Optional)</label>
                                <textarea name="specifications" 
                                          id="specifications"
                                          rows="3"
                                          class="form-input @error('specifications') border-red-500 @enderror"
                                          placeholder="Technical specifications, features, etc.">{{ old('specifications') }}</textarea>
                                @error('specifications')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Pricing -->
                    <div class="card p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Pricing</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="price" class="form-label">Regular Price ($)</label>
                                <input type="number" 
                                       name="price" 
                                       id="price"
                                       step="0.01"
                                       min="0"
                                       class="form-input @error('price') border-red-500 @enderror"
                                       value="{{ old('price') }}"
                                       required>
                                @error('price')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="sale_price" class="form-label">Sale Price ($) - Optional</label>
                                <input type="number" 
                                       name="sale_price" 
                                       id="sale_price"
                                       step="0.01"
                                       min="0"
                                       class="form-input @error('sale_price') border-red-500 @enderror"
                                       value="{{ old('sale_price') }}">
                                @error('sale_price')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="card p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Product Details</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="brand" class="form-label">Brand (Optional)</label>
                                <input type="text" 
                                       name="brand" 
                                       id="brand"
                                       class="form-input @error('brand') border-red-500 @enderror"
                                       value="{{ old('brand') }}">
                                @error('brand')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="weight" class="form-label">Weight (kg) - Optional</label>
                                <input type="number" 
                                       name="weight" 
                                       id="weight"
                                       step="0.01"
                                       min="0"
                                       class="form-input @error('weight') border-red-500 @enderror"
                                       value="{{ old('weight') }}">
                                @error('weight')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="firing_range" class="form-label">Firing Range (Optional)</label>
                                <input type="text" 
                                       name="firing_range" 
                                       id="firing_range"
                                       class="form-input @error('firing_range') border-red-500 @enderror"
                                       value="{{ old('firing_range') }}"
                                       placeholder="e.g., 25-30m">
                                @error('firing_range')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="build_material" class="form-label">Build Material (Optional)</label>
                                <input type="text" 
                                       name="build_material" 
                                       id="build_material"
                                       class="form-input @error('build_material') border-red-500 @enderror"
                                       value="{{ old('build_material') }}"
                                       placeholder="e.g., Nylon + Metal">
                                @error('build_material')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Product Images -->
                    <div class="card p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Product Images</h2>
                        
                        <div>
                            <label for="images" class="form-label">Upload Images</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500">
                                            <span>Upload files</span>
                                            <input id="images" 
                                                   name="images[]" 
                                                   type="file" 
                                                   class="sr-only" 
                                                   multiple
                                                   accept="image/*">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG up to 5MB each</p>
                                </div>
                            </div>
                            @error('images.*')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Inventory -->
                    <div class="card p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Inventory</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="sku" class="form-label">SKU (Optional)</label>
                                <input type="text" 
                                       name="sku" 
                                       id="sku"
                                       class="form-input @error('sku') border-red-500 @enderror"
                                       value="{{ old('sku') }}"
                                       placeholder="Auto-generated if empty">
                                @error('sku')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="stock_quantity" class="form-label">Stock Quantity</label>
                                <input type="number" 
                                       name="stock_quantity" 
                                       id="stock_quantity"
                                       min="0"
                                       class="form-input @error('stock_quantity') border-red-500 @enderror"
                                       value="{{ old('stock_quantity', 0) }}"
                                       required>
                                @error('stock_quantity')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="manage_stock" 
                                       id="manage_stock"
                                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                                       {{ old('manage_stock', true) ? 'checked' : '' }}>
                                <label for="manage_stock" class="ml-2 text-sm text-gray-700">
                                    Track stock quantity
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="card p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Status</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="status" class="form-label">Product Status</label>
                                <select name="status" 
                                        id="status"
                                        class="form-input @error('status') border-red-500 @enderror"
                                        required>
                                    <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="is_featured" 
                                       id="is_featured"
                                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                                       {{ old('is_featured') ? 'checked' : '' }}>
                                <label for="is_featured" class="ml-2 text-sm text-gray-700">
                                    Featured product
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card p-6">
                        <div class="space-y-3">
                            <button type="submit" class="w-full btn-primary">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Create Product
                            </button>
                            
                            <a href="{{ route('admin.products.index') }}" class="w-full btn-outline block text-center">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Auto-generate SKU based on product name
document.getElementById('name').addEventListener('input', function() {
    const skuField = document.getElementById('sku');
    if (!skuField.value) {
        const name = this.value;
        const sku = 'GB-' + name.replace(/[^a-zA-Z0-9]/g, '').toUpperCase().substring(0, 8);
        skuField.placeholder = sku;
    }
});

// Price validation
document.getElementById('sale_price').addEventListener('input', function() {
    const regularPrice = parseFloat(document.getElementById('price').value) || 0;
    const salePrice = parseFloat(this.value) || 0;
    
    if (salePrice > 0 && salePrice >= regularPrice) {
        this.setCustomValidity('Sale price must be less than regular price');
    } else {
        this.setCustomValidity('');
    }
});

// Image preview
document.getElementById('images').addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    const previewContainer = document.getElementById('image-preview');
    
    if (!previewContainer) {
        const container = document.createElement('div');
        container.id = 'image-preview';
        container.className = 'mt-4 grid grid-cols-2 md:grid-cols-4 gap-4';
        this.parentElement.parentElement.parentElement.appendChild(container);
    }
    
    document.getElementById('image-preview').innerHTML = '';
    
    files.forEach((file, index) => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('div');
                preview.className = 'relative';
                preview.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border">
                    <div class="absolute top-1 right-1 bg-black bg-opacity-50 text-white text-xs px-1 rounded">
                        ${index + 1}
                    </div>
                `;
                document.getElementById('image-preview').appendChild(preview);
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush
@endsection