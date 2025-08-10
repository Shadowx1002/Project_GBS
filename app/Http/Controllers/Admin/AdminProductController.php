<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'primaryImage']);

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'ILIKE', "%{$searchTerm}%")
                  ->orWhere('sku', 'ILIKE', "%{$searchTerm}%")
                  ->orWhere('brand', 'ILIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'ILIKE', "%{$searchTerm}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Stock status filter
        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'in_stock':
                    $query->where('in_stock', true);
                    break;
                case 'out_of_stock':
                    $query->where('in_stock', false);
                    break;
                case 'low_stock':
                    $query->where('stock_quantity', '<=', 10)->where('in_stock', true);
                    break;
            }
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        $query->orderBy($sortBy, $sortOrder);

        $products = $query->paginate(20)->withQueryString();
        $categories = Category::active()->ordered()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->ordered()->get();
        
        if ($categories->isEmpty()) {
            return redirect()->route('admin.products.index')
                           ->with('error', 'Please create at least one category before adding products.');
        }
        
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Enhanced validation with custom messages
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|min:10',
            'specifications' => 'nullable|string|max:2000',
            'price' => 'required|numeric|min:0.01|max:99999.99',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'nullable|string|unique:products,sku|max:50',
            'stock_quantity' => 'required|integer|min:0|max:99999',
            'brand' => 'nullable|string|max:100',
            'weight' => 'nullable|numeric|min:0|max:999.99',
            'firing_range' => 'nullable|string|max:50',
            'build_material' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'boolean',
            'manage_stock' => 'boolean',
            'images.*' => 'image|mimes:jpeg,jpg,png,webp|max:5120', // 5MB max
            'image_urls' => 'nullable|string',
        ], [
            'name.required' => 'Product name is required.',
            'name.unique' => 'A product with this name already exists.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category does not exist.',
            'description.required' => 'Product description is required.',
            'description.min' => 'Description must be at least 10 characters.',
            'price.required' => 'Price is required.',
            'price.min' => 'Price must be greater than $0.00.',
            'sale_price.lt' => 'Sale price must be less than regular price.',
            'stock_quantity.required' => 'Stock quantity is required.',
            'images.*.image' => 'All uploaded files must be images.',
            'images.*.mimes' => 'Images must be JPEG, JPG, PNG, or WebP format.',
            'images.*.max' => 'Each image must be smaller than 5MB.',
        ]);

        DB::beginTransaction();

        try {
            // Create the product
            $product = Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'category_id' => $request->category_id,
                'description' => $request->description,
                'specifications' => $request->specifications,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'sku' => $request->sku ?: $this->generateUniqueSKU($request->name),
                'stock_quantity' => $request->stock_quantity,
                'manage_stock' => $request->boolean('manage_stock', true),
                'in_stock' => $request->stock_quantity > 0,
                'is_featured' => $request->boolean('is_featured'),
                'status' => $request->status,
                'brand' => $request->brand,
                'weight' => $request->weight,
                'firing_range' => $request->firing_range,
                'build_material' => $request->build_material,
            ]);

            $imageCount = 0;
            
            // Handle file uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    try {
                        $path = $image->store('products', 'public');
                        
                        ProductImage::create([
                            'product_id' => $product->id,
                            'image_path' => $path,
                            'alt_text' => $product->name,
                            'is_primary' => $imageCount === 0,
                            'sort_order' => $imageCount,
                        ]);
                        
                        $imageCount++;
                    } catch (\Exception $e) {
                        Log::error('Failed to upload image: ' . $e->getMessage());
                        // Continue with other images
                    }
                }
            }
            
            // Handle image URLs
            if ($request->filled('image_urls')) {
                $urls = array_filter(array_map('trim', explode("\n", $request->image_urls)));
                
                foreach ($urls as $url) {
                    if (filter_var($url, FILTER_VALIDATE_URL) && $this->isValidImageUrl($url)) {
                        try {
                            ProductImage::create([
                                'product_id' => $product->id,
                                'image_path' => $url,
                                'alt_text' => $product->name,
                                'is_primary' => $imageCount === 0,
                                'sort_order' => $imageCount,
                            ]);
                            
                            $imageCount++;
                        } catch (\Exception $e) {
                            Log::error('Failed to save image URL: ' . $e->getMessage());
                            // Continue with other URLs
                        }
                    }
                }
            }
            
            // Create default placeholder image if no images provided
            if ($imageCount === 0) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'https://images.pexels.com/photos/163064/play-stone-network-networked-interactive-163064.jpeg',
                    'alt_text' => $product->name,
                    'is_primary' => true,
                    'sort_order' => 0,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                           ->with('success', "Product '{$product->name}' created successfully! {$imageCount} images added.");
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Product creation failed: ' . $e->getMessage(), [
                'request_data' => $request->except(['images', '_token']),
                'user_id' => auth()->id(),
            ]);
            
            return back()->withInput()
                         ->with('error', 'Failed to create product. Please try again. Error: ' . $e->getMessage());
        }
    }

    public function show(Product $product)
    {
        $product->load(['category', 'images', 'orderItems']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->ordered()->get();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|min:10',
            'specifications' => 'nullable|string|max:2000',
            'price' => 'required|numeric|min:0.01|max:99999.99',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id . '|max:50',
            'stock_quantity' => 'required|integer|min:0|max:99999',
            'brand' => 'nullable|string|max:100',
            'weight' => 'nullable|numeric|min:0|max:999.99',
            'firing_range' => 'nullable|string|max:50',
            'build_material' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'boolean',
            'manage_stock' => 'boolean',
            'images.*' => 'image|mimes:jpeg,jpg,png,webp|max:5120',
            'image_urls' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $product->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'category_id' => $request->category_id,
                'description' => $request->description,
                'specifications' => $request->specifications,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'sku' => $request->sku ?: $product->sku,
                'stock_quantity' => $request->stock_quantity,
                'manage_stock' => $request->boolean('manage_stock', true),
                'in_stock' => $request->stock_quantity > 0,
                'is_featured' => $request->boolean('is_featured'),
                'status' => $request->status,
                'brand' => $request->brand,
                'weight' => $request->weight,
                'firing_range' => $request->firing_range,
                'build_material' => $request->build_material,
            ]);

            // Handle new image uploads
            if ($request->hasFile('images')) {
                $currentImageCount = $product->images()->count();
                
                foreach ($request->file('images') as $image) {
                    try {
                        $path = $image->store('products', 'public');
                        
                        ProductImage::create([
                            'product_id' => $product->id,
                            'image_path' => $path,
                            'alt_text' => $product->name,
                            'is_primary' => $currentImageCount === 0,
                            'sort_order' => $currentImageCount,
                        ]);
                        
                        $currentImageCount++;
                    } catch (\Exception $e) {
                        Log::error('Failed to upload image during update: ' . $e->getMessage());
                    }
                }
            }
            
            // Handle new image URLs
            if ($request->filled('image_urls')) {
                $currentImageCount = $product->images()->count();
                $urls = array_filter(array_map('trim', explode("\n", $request->image_urls)));
                
                foreach ($urls as $url) {
                    if (filter_var($url, FILTER_VALIDATE_URL) && $this->isValidImageUrl($url)) {
                        try {
                            ProductImage::create([
                                'product_id' => $product->id,
                                'image_path' => $url,
                                'alt_text' => $product->name,
                                'is_primary' => $currentImageCount === 0,
                                'sort_order' => $currentImageCount,
                            ]);
                            
                            $currentImageCount++;
                        } catch (\Exception $e) {
                            Log::error('Failed to save image URL during update: ' . $e->getMessage());
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                           ->with('success', "Product '{$product->name}' updated successfully!");
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Product update failed: ' . $e->getMessage(), [
                'product_id' => $product->id,
                'user_id' => auth()->id(),
            ]);
            
            return back()->withInput()
                         ->with('error', 'Failed to update product. Please try again.');
        }
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();

        try {
            // Delete associated images
            foreach ($product->images as $image) {
                if (!filter_var($image->image_path, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($image->image_path);
                }
                $image->delete();
            }

            $productName = $product->name;
            $product->delete();

            DB::commit();

            return redirect()->route('admin.products.index')
                           ->with('success', "Product '{$productName}' deleted successfully.");
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Product deletion failed: ' . $e->getMessage(), [
                'product_id' => $product->id,
                'user_id' => auth()->id(),
            ]);
            
            return back()->with('error', 'Failed to delete product. Please try again.');
        }
    }

    public function deleteImage(ProductImage $image)
    {
        try {
            // Delete file from storage if it's not a URL
            if (!filter_var($image->image_path, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($image->image_path);
            }
            
            $productId = $image->product_id;
            $wasPrimary = $image->is_primary;
            
            $image->delete();
            
            // If deleted image was primary, make another image primary
            if ($wasPrimary) {
                $newPrimary = ProductImage::where('product_id', $productId)->first();
                if ($newPrimary) {
                    $newPrimary->update(['is_primary' => true]);
                }
            }
            
            return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
            
        } catch (\Exception $e) {
            Log::error('Image deletion failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete image'], 500);
        }
    }

    public function stockAlerts()
    {
        $lowStock = Product::where('stock_quantity', '<=', 10)
                          ->where('stock_quantity', '>', 0)
                          ->where('manage_stock', true)
                          ->count();
                          
        $outOfStock = Product::where('in_stock', false)->count();
        
        return response()->json([
            'low_stock_count' => $lowStock,
            'out_of_stock_count' => $outOfStock
        ]);
    }

    public function toggleStatus(Product $product, Request $request)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);
        
        try {
            $product->update(['status' => $request->status]);
            
            return response()->json([
                'success' => true, 
                'message' => "Product status updated to {$request->status}",
                'new_status' => $request->status
            ]);
            
        } catch (\Exception $e) {
            Log::error('Status toggle failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update status'], 500);
        }
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
            'action' => 'required|in:activate,deactivate,delete,update_stock',
            'stock_quantity' => 'required_if:action,update_stock|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            $products = Product::whereIn('id', $request->product_ids);
            $count = $products->count();

            switch ($request->action) {
                case 'activate':
                    $products->update(['status' => 'active']);
                    $message = "{$count} products activated successfully.";
                    break;
                    
                case 'deactivate':
                    $products->update(['status' => 'inactive']);
                    $message = "{$count} products deactivated successfully.";
                    break;
                    
                case 'update_stock':
                    $products->update([
                        'stock_quantity' => $request->stock_quantity,
                        'in_stock' => $request->stock_quantity > 0
                    ]);
                    $message = "{$count} products stock updated successfully.";
                    break;
                    
                case 'delete':
                    foreach ($products->get() as $product) {
                        // Delete images
                        foreach ($product->images as $image) {
                            if (!filter_var($image->image_path, FILTER_VALIDATE_URL)) {
                                Storage::disk('public')->delete($image->image_path);
                            }
                            $image->delete();
                        }
                        $product->delete();
                    }
                    $message = "{$count} products deleted successfully.";
                    break;
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => $message]);
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Bulk update failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Bulk operation failed'], 500);
        }
    }

    private function generateUniqueSKU($productName)
    {
        $base = 'GB-' . strtoupper(Str::slug($productName, ''));
        $base = substr($base, 0, 15); // Limit length
        
        $sku = $base;
        $counter = 1;
        
        while (Product::where('sku', $sku)->exists()) {
            $sku = $base . '-' . $counter;
            $counter++;
        }
        
        return $sku;
    }

    private function isValidImageUrl($url)
    {
        // Check if URL ends with common image extensions
        return preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $url);
    }

    public function export(Request $request)
    {
        $query = Product::with(['category']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'ILIKE', "%{$searchTerm}%")
                  ->orWhere('sku', 'ILIKE', "%{$searchTerm}%")
                  ->orWhere('brand', 'ILIKE', "%{$searchTerm}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->get();

        $csvData = [];
        $csvData[] = ['Name', 'SKU', 'Category', 'Brand', 'Price', 'Sale Price', 'Stock', 'Status', 'Created'];

        foreach ($products as $product) {
            $csvData[] = [
                $product->name,
                $product->sku,
                $product->category->name,
                $product->brand ?: '',
                $product->price,
                $product->sale_price ?: '',
                $product->stock_quantity,
                $product->status,
                $product->created_at->format('Y-m-d'),
            ];
        }

        $filename = 'products_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($csvData) {
            $file = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}