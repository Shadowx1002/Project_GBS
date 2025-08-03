<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    

    public function dashboard()
    {
        // Get date ranges
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        // Key metrics
        $metrics = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_users' => User::where('is_admin', false)->count(),
            'total_products' => Product::count(),
            'out_of_stock' => Product::where('in_stock', false)->count(),
        ];

        // Today's stats
        $todayStats = [
            'orders' => Order::whereDate('created_at', $today)->count(),
            'revenue' => Order::whereDate('created_at', $today)->where('payment_status', 'paid')->sum('total_amount'),
            'new_users' => User::whereDate('created_at', $today)->where('is_admin', false)->count(),
        ];

        // Recent orders
        $recentOrders = Order::with('user')
                            ->latest()
                            ->limit(10)
                            ->get();

        // Revenue chart data (last 30 days)
        $revenueData = Order::where('payment_status', 'paid')
                           ->where('created_at', '>=', Carbon::now()->subDays(30))
                           ->select(
                               DB::raw('DATE(created_at) as date'),
                               DB::raw('SUM(total_amount) as revenue'),
                               DB::raw('COUNT(*) as orders')
                           )
                           ->groupBy('date')
                           ->orderBy('date')
                           ->get();

        // Top products
        $topProducts = Product::select('products.*')
                              ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
                              ->selectRaw('SUM(order_items.quantity) as total_sold')
                              ->groupBy('products.id')
                              ->orderBy('total_sold', 'desc')
                              ->limit(5)
                              ->get();

        return view('admin.dashboard', compact(
            'metrics', 'todayStats', 'recentOrders', 'revenueData', 'topProducts'
            ));
}
}