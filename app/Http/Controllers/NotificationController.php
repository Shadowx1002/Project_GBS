<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function check()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Check for new orders in the last 5 minutes
        $newOrders = Order::where('created_at', '>=', now()->subMinutes(5))->count();
        

        return response()->json([
            'new_orders' => $newOrders,
        ]);
    }

    public function userNotifications()
    {
        $user = Auth::user();
        
        $notifications = [];
        
        // Check for order updates
        $recentOrders = $user->orders()
                           ->where('updated_at', '>=', now()->subDays(7))
                           ->where('updated_at', '>', $user->last_notification_check ?? now()->subWeek())
                           ->get();

        foreach ($recentOrders as $order) {
            $notifications[] = [
                'type' => 'order_update',
                'title' => 'Order Update',
                'message' => "Your order #{$order->order_number} is now {$order->status}",
                'url' => route('orders.show', $order),
                'created_at' => $order->updated_at
            ];
        }

        // Update last notification check
        $user->update(['last_notification_check' => now()]);

        return response()->json($notifications);
    }
}