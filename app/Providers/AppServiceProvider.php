<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share categories with all views
        View::composer('*', function ($view) {
            $categories = Category::active()->ordered()->get();
            $view->with('globalCategories', $categories);
        });
    }
}