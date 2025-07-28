<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('age_verified')->only(['add', 'update']);
    }

    public function index()
    {
        $cartItems = Auth::user()->cartItems()
                               ->with(['product.primaryImage', 'product.category'])
                               ->get();

        // Calculate totals
        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $taxRate = 0.08; // 8% tax
        $taxAmount = $subtotal * $taxRate;
        $shippingAmount = $subtotal >= 100 ? 0 : 9.99; // Free shipping over $100
        $total = $subtotal + $taxAmount + $shippingAmount;

        return view('cart.index', compact(
            'cartItems', 'subtotal', 'taxAmount', 'shippingAmount', 'total'
        ));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1|max:10'
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;

        // Check if product is available
        if (!$product->isAvailable()) {
            return response()->json([
                'success' => false,
                'message' => 'Product is not available'
            ], 400);
        }

        // Check stock
        if (!$product->canPurchase($quantity)) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock'
            ], 400);
        }

        // Check if item already exists in cart
        $cartItem = CartItem::where('user_id', Auth::id())
                           ->where('product_id', $product->id)
                           ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            
            if (!$product->canPurchase($newQuantity)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot add more items. Stock limit exceeded.'
                ], 400);
            }

            $cartItem->update([
                'quantity' => $newQuantity,
                'price' => $product->current_price
            ]);
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->current_price
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully'
        ]);
    }

    public function update(Request $request, CartItem $cartItem)
    {
        // Ensure user owns this cart item
        if ($cartItem->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $product = $cartItem->product;
        $quantity = $request->quantity;

        // Check stock
        if (!$product->canPurchase($quantity)) {
            return back()->with('error', 'Insufficient stock for the requested quantity.');
        }

        $cartItem->update([
            'quantity' => $quantity,
            'price' => $product->current_price // Update price in case it changed
        ]);

        return back()->with('success', 'Cart updated successfully.');
    }

    public function remove(CartItem $cartItem)
    {
        // Ensure user owns this cart item
        if ($cartItem->user_id !== Auth::id()) {
            abort(403);
        }

        $cartItem->delete();

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        Auth::user()->cartItems()->delete();

        return back()->with('success', 'Cart cleared successfully.');
    }

    public function count()
    {
        $count = Auth::check() ? Auth::user()->cartItems->sum('quantity') : 0;

        return response()->json(['count' => $count]);
    }

    public function items()
    {
        if (!Auth::check()) {
            return response('', 204);
        }

        $cartItems = Auth::user()->cartItems()
                               ->with(['product.primaryImage'])
                               ->limit(5)
                               ->get();

        return view('cart.items', compact('cartItems'));
    }
}