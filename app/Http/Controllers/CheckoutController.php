<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'age_verified']);
    }

    public function index()
    {
        $cartItems = Auth::user()->cartItems()
                               ->with(['product.primaryImage', 'product.category'])
                               ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Validate cart items availability
        foreach ($cartItems as $item) {
            if (!$item->isProductAvailable() || !$item->canFulfillQuantity()) {
                return redirect()->route('cart.index')->with('error', 
                    'Some items in your cart are no longer available. Please review your cart.');
            }
        }

        // Calculate totals
        $subtotal = $cartItems->sum('total_price');
        $taxRate = 0.08;
        $taxAmount = $subtotal * $taxRate;
        $shippingAmount = $subtotal >= 100 ? 0 : 9.99;
        $total = $subtotal + $taxAmount + $shippingAmount;

        $user = Auth::user();

        return view('checkout.index', compact(
            'cartItems', 'subtotal', 'taxAmount', 'shippingAmount', 'total', 'user'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_first_name' => 'required|string|max:255',
            'shipping_last_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'nullable|string|max:20',
            'shipping_address_line_1' => 'required|string|max:255',
            'shipping_address_line_2' => 'nullable|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'payment_method' => 'required|in:stripe,paypal,credit_card',
            'notes' => 'nullable|string|max:1000',
            'terms_accepted' => 'required|accepted',
        ]);

        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            // Calculate totals
            $subtotal = $cartItems->sum('total_price');
            $taxRate = 0.08;
            $taxAmount = $subtotal * $taxRate;
            $shippingAmount = $subtotal >= 100 ? 0 : 9.99;
            $total = $subtotal + $taxAmount + $shippingAmount;

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'shipping_amount' => $shippingAmount,
                'total_amount' => $total,
                'currency' => 'USD',
                'payment_method' => $request->payment_method,
                'shipping_first_name' => $request->shipping_first_name,
                'shipping_last_name' => $request->shipping_last_name,
                'shipping_email' => $request->shipping_email,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address_line_1' => $request->shipping_address_line_1,
                'shipping_address_line_2' => $request->shipping_address_line_2,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_postal_code' => $request->shipping_postal_code,
                'shipping_country' => $request->shipping_country,
                'notes' => $request->notes,
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                if (!$cartItem->isProductAvailable() || !$cartItem->canFulfillQuantity()) {
                    throw new \Exception('Product ' . $cartItem->product->name . ' is no longer available.');
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'product_sku' => $cartItem->product->sku,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->price,
                    'total_price' => $cartItem->total_price,
                ]);

                // Update product stock
                if ($cartItem->product->manage_stock) {
                    $cartItem->product->decrement('stock_quantity', $cartItem->quantity);
                    
                    // Mark as out of stock if needed
                    if ($cartItem->product->stock_quantity <= 0) {
                        $cartItem->product->update(['in_stock' => false]);
                    }
                }
            }

            // Process payment (simulation)
            $paymentResult = $this->processPayment($order, $request->payment_method);

            if ($paymentResult['success']) {
                $order->update([
                    'payment_status' => 'paid',
                    'payment_id' => $paymentResult['payment_id'],
                    'status' => 'processing'
                ]);

                // Clear cart
                $user->cartItems()->delete();

                // Send confirmation email
                try {
                    Mail::to($order->shipping_email)->send(new OrderConfirmation($order));
                } catch (\Exception $e) {
                    // Log email error but don't fail the order
                    \Log::error('Failed to send order confirmation email: ' . $e->getMessage());
                }

                DB::commit();

                return redirect()->route('checkout.success', $order)->with('success', 
                    'Order placed successfully! Confirmation email sent.');
            } else {
                throw new \Exception('Payment failed: ' . $paymentResult['message']);
            }

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Order failed: ' . $e->getMessage());
        }
    }

    public function success(Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }

    private function processPayment(Order $order, string $method): array
    {
        // This is a simulation - in production, integrate with real payment gateways
        
        switch ($method) {
            case 'stripe':
                return $this->processStripePayment($order);
            case 'paypal':
                return $this->processPayPalPayment($order);
            case 'credit_card':
                return $this->processCreditCardPayment($order);
            default:
                return ['success' => false, 'message' => 'Invalid payment method'];
        }
    }

    private function processStripePayment(Order $order): array
    {
        // Stripe payment simulation
        sleep(2); // Simulate processing time
        
        $success = rand(1, 100) > 5; // 95% success rate
        
        return [
            'success' => $success,
            'payment_id' => $success ? 'stripe_' . uniqid() : null,
            'message' => $success ? 'Payment successful' : 'Card declined'
        ];
    }

    private function processPayPalPayment(Order $order): array
    {
        // PayPal payment simulation
        sleep(1);
        
        $success = rand(1, 100) > 3; // 97% success rate
        
        return [
            'success' => $success,
            'payment_id' => $success ? 'paypal_' . uniqid() : null,
            'message' => $success ? 'Payment successful' : 'PayPal payment failed'
        ];
    }

    private function processCreditCardPayment(Order $order): array
    {
        // Credit card payment simulation
        sleep(3);
        
        $success = rand(1, 100) > 8; // 92% success rate
        
        return [
            'success' => $success,
            'payment_id' => $success ? 'cc_' . uniqid() : null,
            'message' => $success ? 'Payment successful' : 'Credit card payment failed'
        ];
    }
}