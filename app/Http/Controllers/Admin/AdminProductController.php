<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $query = Product::with(['category', 'primaryImage']);

        // Search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'ILIKE', "%{$searchTerm}%")
                  ->orWhere('sku', 'ILIKE', "%{$searchTerm}%")
                  ->orWhere('brand', 'ILIKE', "%{$searchTerm}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by stock status
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'in_stock') {
                $query->where('in_stock', true);
            } elseif ($request->stock_status === 'out_of_stock') {
                $query->where('in_stock', false);
            } elseif ($request->stock_status === 'low_stock') {
                $query->where('stock_quantity', '<=', 10)->where('in_stock', true);
            }
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(20);
        $categories = Category::active()->ordered()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'specifications' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'nullable|string|unique:products,sku',
            'stock_quantity' => 'required|integer|min:0',
            'brand' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'firing_range' => 'nullable|string|max:255',
            'build_material' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'boolean',
            'manage_stock' => 'boolean',
            'images.*' => 'image|mimes:jpeg,jpg,png|max:5120',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'specifications' => $request->specifications,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'sku' => $request->sku ?: 'GB-' . strtoupper(Str::random(8)),
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

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'alt_text' => $product->name,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        } else {
            // Create default placeholder image
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'https://images.pexels.com/photos/163064/play-stone-network-networked-interactive-163064.jpeg',
                'alt_text' => $product->name,
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
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
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'specifications' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'stock_quantity' => 'required|integer|min:0',
            'brand' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'firing_range' => 'nullable|string|max:255',
            'build_material' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'boolean',
            'manage_stock' => 'boolean',
            'images.*' => 'image|mimes:jpeg,jpg,png|max:5120',
            'image_urls' => 'nullable|string',
        ]);

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'specifications' => $request->specifications,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'sku' => $request->sku,
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
                $path = $image->store('products', 'public');
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'alt_text' => $product->name,
                    'is_primary' => $currentImageCount === 0,
                    'sort_order' => $currentImageCount,
                ]);
                $currentImageCount++;
            }
        }
        
        // Handle image URLs
        if ($request->filled('image_urls')) {
            $currentImageCount = $product->images()->count();
            $urls = array_filter(array_map('trim', explode("\n", $request->image_urls)));
            
            foreach ($urls as $url) {
                if (filter_var($url, FILTER_VALIDATE_URL)) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $url,
                        'alt_text' => $product->name,
                        'is_primary' => $currentImageCount === 0,
                        'sort_order' => $currentImageCount,
                    ]);
                    $currentImageCount++;
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Delete images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function deleteImage(ProductImage $image)
    {
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
        
        return response()->json(['success' => true]);
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
        
        $product->update(['status' => $request->status]);
        
        return response()->json(['success' => true]);
    }
}