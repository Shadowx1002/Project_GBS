<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdate;

class AdminOrderController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by order number or customer
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('order_number', 'ILIKE', "%{$searchTerm}%")
                  ->orWhere('shipping_email', 'ILIKE', "%{$searchTerm}%")
                  ->orWhere('shipping_first_name', 'ILIKE', "%{$searchTerm}%")
                  ->orWhere('shipping_last_name', 'ILIKE', "%{$searchTerm}%");
            });
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'notes' => 'nullable|string|max:1000',
            'tracking_number' => 'nullable|string|max:255'
        ]);

        $oldStatus = $order->status;
        
        $order->update([
            'status' => $request->status,
            'notes' => $request->notes,
            'tracking_number' => $request->tracking_number
        ]);

        // Update timestamps based on status
        if ($request->status === 'shipped' && $oldStatus !== 'shipped') {
            $order->update(['shipped_at' => now()]);
        } elseif ($request->status === 'delivered' && $oldStatus !== 'delivered') {
            $order->update(['delivered_at' => now()]);
        }

        // Send notification email if status changed
        if ($oldStatus !== $request->status) {
            try {
                Mail::to($order->shipping_email)->send(
                    new OrderStatusUpdate($order, $oldStatus, $request->status)
                );
            } catch (\Exception $e) {
                \Log::error('Failed to send order status update email: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Order updated successfully.');
    }
}