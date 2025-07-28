<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Cache the data for 1 hour to improve performance
        $featuredProducts = Product::with(['category', 'primaryImage'])
                                 ->active()
                                 ->featured()
                                 ->inStock()
                                 ->limit(8)
                                 ->get();

        $categories = Category::active()->ordered()->get();

        return view('home', compact('featuredProducts', 'categories'));
    }
}