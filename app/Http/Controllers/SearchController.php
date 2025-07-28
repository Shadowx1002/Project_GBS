<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function suggestions(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        // Search products
        $products = Product::active()
                          ->inStock()
                          ->where(function ($q) use ($query) {
                              $q->where('name', 'ILIKE', "%{$query}%")
                                ->orWhere('brand', 'ILIKE', "%{$query}%");
                          })
                          ->with(['category', 'primaryImage'])
                          ->limit(5)
                          ->get();

        // Search categories
        $categories = Category::active()
                            ->where('name', 'ILIKE', "%{$query}%")
                            ->limit(3)
                            ->get();

        return response()->json([
            'products' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->current_price,
                    'image' => $product->primary_image_url,
                    'url' => route('products.show', $product->slug),
                    'category' => $product->category->name
                ];
            }),
            'categories' => $categories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'url' => route('products.category', $category->slug)
                ];
            })
        ]);
    }

    public function index(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return redirect()->route('products.index');
        }

        $products = Product::active()
                          ->inStock()
                          ->where(function ($q) use ($query) {
                              $q->where('name', 'ILIKE', "%{$query}%")
                                ->orWhere('description', 'ILIKE', "%{$query}%")
                                ->orWhere('brand', 'ILIKE', "%{$query}%");
                          })
                          ->with(['category', 'primaryImage'])
                          ->paginate(12);
        return view('products.search', compact('products', 'query'));
    }
}