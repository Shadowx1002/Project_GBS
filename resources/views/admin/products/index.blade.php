@extends('layouts.app')

@section('title', 'Manage Products')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="container-custom py-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Products</h1>
                    <p class="text-gray-600 mt-1">Manage your product catalog</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.products.create') }}" class="btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Product
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-custom py-8">
        <!-- Filters -->
        <div class="card p-6 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <input type="text" 
                           name="search" 
                           placeholder="Search products..." 
                           value="{{ request('search') }}"
                           class="form-input">
                </div>

                <!-- Category Filter -->
                <div>
                    <select name="category" class="form-input">
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
                    <select name="status" class="form-input">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Stock Status Filter -->
                <div>
                    <select name="stock_status" class="form-input">
                        <option value="">All Stock</option>
                        <option value="in_stock" {{ request('stock_status') === 'in_stock' ? 'selected' : '' }}>In Stock</option>
                        <option value="out_of_stock" {{ request('stock_status') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                        <option value="low_stock" {{ request('stock_status') === 'low_stock' ? 'selected' : '' }}>Low Stock (≤10)</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full btn-primary">Filter</button>
                </div>
            </form>
        </div>

        <!-- Products Table -->
        <div class="card overflow-hidden">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $product->primary_image_url }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-12 h-12 object-cover rounded-lg">
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $product->name }}</div>
                                            <div class="text-sm text-gray-500">SKU: {{ $product->sku }}</div>
                                            @if($product->brand)
                                                <div class="text-sm text-gray-500">{{ $product->brand }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-info">{{ $product->category->name }}</span>
                                </td>
                                <td>
                                    <div class="flex flex-col">
                                        @if($product->isOnSale())
                                            <span class="text-red-600 font-medium">${{ $product->sale_price }}</span>
                                            <span class="text-gray-500 line-through text-sm">${{ $product->price }}</span>
                                        @else
                                            <span class="font-medium">${{ $product->price }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
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
                                        <span class="text-gray-500">Not tracked</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex flex-col space-y-1">
                                        @if($product->status === 'active')
                                            <span class="badge-success">Active</span>
                                        @else
                                            <span class="badge-danger">Inactive</span>
                                        @endif
                                        
                                        @if($product->is_featured)
                                            <span class="badge-info text-xs">Featured</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="text-sm text-gray-900">{{ $product->created_at->format('M j, Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $product->created_at->format('g:i A') }}</div>
                                </td>
                                <td>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.products.show', $product) }}" 
                                           class="text-blue-600 hover:text-blue-700" title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        
                                        <a href="{{ route('admin.products.edit', $product) }}" 
                                           class="text-green-600 hover:text-green-700" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        
                                        <a href="{{ route('products.show', $product->slug) }}" 
                                           target="_blank"
                                           class="text-purple-600 hover:text-purple-700" title="View on Site">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                        
                                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" 
                                              class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-700" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <p class="text-gray-500">No products found</p>
                                    <a href="{{ route('admin.products.create') }}" class="btn-primary mt-4">
                                        Add Your First Product
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($products->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $products->links() }}
                </div>
            @endif
        </div>

        <!-- Bulk Actions (Future Enhancement) -->
        <div class="mt-6 card p-4">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} products
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-sm text-blue-600 hover:text-blue-700" onclick="exportProducts()">
                        Export CSV
                    </button>
                    <button class="text-sm text-green-600 hover:text-green-700" onclick="bulkUpdateStock()">
                        Bulk Update Stock
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function exportProducts() {
    // Create CSV export functionality
    const params = new URLSearchParams(window.location.search);
    params.set('export', 'csv');
    
    const exportUrl = window.location.pathname + '?' + params.toString();
    window.open(exportUrl, '_blank');
}

function bulkUpdateStock() {
    // Placeholder for bulk stock update functionality
    alert('Bulk stock update functionality coming soon!');
}

// Auto-refresh stock warnings
function checkStockLevels() {
    fetch('/admin/products/stock-alerts')
        .then(response => response.json())
        .then(data => {
            if (data.low_stock_count > 0) {
                showNotification(`${data.low_stock_count} products are running low on stock`, 'warning');
            }
            if (data.out_of_stock_count > 0) {
                showNotification(`${data.out_of_stock_count} products are out of stock`, 'error');
            }
        })
        .catch(error => console.error('Error checking stock levels:', error));
}

// Check stock levels every 10 minutes
setInterval(checkStockLevels, 600000);

// Enhanced search with debouncing
let searchTimeout;
document.querySelector('input[name="search"]').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        // Auto-submit form after 500ms of no typing
        if (this.value.length >= 3 || this.value.length === 0) {
            this.form.submit();
        }
    }, 500);
});

// Quick status toggle
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
            location.reload();
        } else {
            alert('Error updating product status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating product status');
    });
}

// Sort table columns
function sortTable(column) {
    const url = new URL(window.location);
    const currentSort = url.searchParams.get('sort');
    const currentOrder = url.searchParams.get('order');
    
    if (currentSort === column) {
        url.searchParams.set('order', currentOrder === 'asc' ? 'desc' : 'asc');
    } else {
        url.searchParams.set('sort', column);
        url.searchParams.set('order', 'asc');
    }
    
    window.location = url.toString();
}
</script>
@endpush
@endsection