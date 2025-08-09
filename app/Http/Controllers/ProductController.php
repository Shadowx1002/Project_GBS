<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'primaryImage'])
                       ->active()
                       ->inStock();

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'ILIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'ILIKE', "%{$searchTerm}%")
                  ->orWhere('brand', 'ILIKE', "%{$searchTerm}%")
                  ->orWhereHas('category', function ($categoryQuery) use ($searchTerm) {
                      $categoryQuery->where('name', 'ILIKE', "%{$searchTerm}%");
                  });
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($categoryQuery) use ($request) {
                $categoryQuery->where('slug', $request->category);
            });
        }

        // Brand filter
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        switch ($sortBy) {
            case 'name':
                $query->orderBy('name', $sortOrder);
                break;
            case 'price':
                $query->orderBy('price', $sortOrder);
                break;
            case 'popularity':
                $query->orderBy('views', 'desc');
                break;
            default:
                $query->orderBy('created_at', $sortOrder);
        }

        // Get products with pagination
        $products = $query->paginate(12)->withQueryString();

        // Get filter data
        $categories = Category::active()->ordered()->get();
        $brands = Product::active()->distinct()->pluck('brand')->filter()->sort();
        $priceRange = [
            'min' => Product::active()->min('price') ?? 0,
            'max' => Product::active()->max('price') ?? 1000
        ];

        return view('products.index', compact(
            'products', 'categories', 'brands', 'priceRange'
        ));
    }

    public function show(Product $product)
    {
        // Check if product is active
        if ($product->status !== 'active') {
            abort(404);
        }

        // Increment view count
        $product->incrementViews();

        // Load relationships
        $product->load(['category', 'images']);

        // Get related products
        $relatedProducts = Product::active()
                                 ->inStock()
                                 ->where('category_id', $product->category_id)
                                 ->where('id', '!=', $product->id)
                                 ->with(['category', 'primaryImage'])
                                 ->limit(4)
                                 ->get();

        // Get recently viewed products from session
        $recentlyViewed = session()->get('recently_viewed', []);
        
        // Add current product to recently viewed
        $recentlyViewed = array_filter($recentlyViewed, fn($id) => $id != $product->id);
        array_unshift($recentlyViewed, $product->id);
        $recentlyViewed = array_slice($recentlyViewed, 0, 5);
        session()->put('recently_viewed', $recentlyViewed);

        return view('products.show', compact('product', 'relatedProducts'));
    }

}