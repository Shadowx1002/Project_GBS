@extends('layouts.app')

@section('title', 'Order Confirmation')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container-custom">
        <!-- Success Header -->
        <div class="text-center mb-12" data-aos="fade-up">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Order Confirmed!</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Thank you for your purchase! Your order has been successfully placed and you'll receive a confirmation email shortly.
            </p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-8" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center justify-center">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-medium">
                            ✓
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Cart</span>
                    </div>
                    <div class="w-16 h-0.5 bg-green-500"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-medium">
                            ✓
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Checkout</span>
                    </div>
                    <div class="w-16 h-0.5 bg-green-500"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-medium">
                            ✓
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Complete</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Order Details -->
            <div class="space-y-6">
                <!-- Order Information -->
                <div class="card p-6" data-aos="fade-right">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Order Information
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Order Number</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $order->order_number }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Order Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $order->created_at->format('M j, Y \a\t g:i A') }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Payment Status</dt>
                            <dd class="mt-1">
                                <span class="badge-success">{{ ucfirst($order->payment_status) }}</span>
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Order Status</dt>
                            <dd class="mt-1">
                                <span class="status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Estimated Delivery</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $order->estimated_delivery }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="card p-6" data-aos="fade-right" data-aos-delay="200">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Shipping Address
                    </h2>
                    
                    <div class="text-sm text-gray-900">
                        <p class="font-medium">{{ $order->shipping_full_name }}</p>
                        <p>{{ $order->shipping_address_line_1 }}</p>
                        @if($order->shipping_address_line_2)
                            <p>{{ $order->shipping_address_line_2 }}</p>
                        @endif
                        <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                        <p>{{ $order->shipping_country }}</p>
                        @if($order->shipping_phone)
                            <p class="mt-2">{{ $order->shipping_phone }}</p>
                        @endif
                        <p class="mt-2">{{ $order->shipping_email }}</p>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="card p-6" data-aos="fade-right" data-aos-delay="400">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        What Happens Next?
                    </h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center mr-3 mt-1">
                                <span class="text-primary-600 text-sm font-medium">1</span>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">Order Processing</h3>
                                <p class="text-sm text-gray-600">We'll review your order and prepare it for shipment. This usually takes 1-2 business days.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center mr-3 mt-1">
                                <span class="text-primary-600 text-sm font-medium">2</span>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">Shipping</h3>
                                <p class="text-sm text-gray-600">Once shipped, you'll receive tracking information via email. Standard delivery takes 3-5 business days.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center mr-3 mt-1">
                                <span class="text-primary-600 text-sm font-medium">3</span>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">Delivery</h3>
                                <p class="text-sm text-gray-600">Your order will be delivered to the address provided. Please ensure someone is available to receive it.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="card p-6 sticky top-24" data-aos="fade-left">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Summary</h2>
                    
                    <!-- Order Items -->
                    <div class="space-y-4 mb-6">
                        @foreach($order->items as $item)
                            <div class="flex items-center space-x-3">
                                @if($item->product)
                                    <img src="{{ $item->product->primary_image_url }}" 
                                         alt="{{ $item->product_name }}" 
                                         class="w-12 h-12 object-cover rounded">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-gray-900 truncate">
                                        {{ $item->product_name }}
                                    </h4>
                                    <p class="text-xs text-gray-500">
                                        SKU: {{ $item->product_sku }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Qty: {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}
                                    </p>
                                </div>
                                
                                <div class="text-sm font-medium text-gray-900">
                                    ${{ number_format($item->total_price, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <hr class="border-gray-200 mb-4">
                    
                    <!-- Totals -->
                    <div class="space-y-2 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-medium">
                                @if($order->shipping_amount > 0)
                                    ${{ number_format($order->shipping_amount, 2) }}
                                @else
                                    <span class="text-green-600">FREE</span>
                                @endif
                            </span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tax</span>
                            <span class="font-medium">${{ number_format($order->tax_amount, 2) }}</span>
                        </div>
                        
                        <hr class="border-gray-200">
                        
                        <div class="flex justify-between text-lg font-semibold">
                            <span>Total Paid</span>
                            <span class="text-primary-600">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <a href="{{ route('orders.show', $order) }}" 
                           class="w-full btn-primary text-center block">
                            View Order Details
                        </a>
                        
                        <a href="{{ route('products.index') }}" 
                           class="w-full btn-outline text-center block">
                            Continue Shopping
                        </a>
                    </div>
                    
                    <!-- Support -->
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600 mb-2">Need help with your order?</p>
                        <a href="/contact" 
                           class="text-sm text-primary-600 hover:text-primary-700 transition-colors">
                            Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6" data-aos="fade-up">
            <!-- Customer Service -->
            <div class="text-center">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Customer Support</h3>
                <p class="text-sm text-gray-600">
                    Questions about your order? Our support team is here to help 24/7.
                </p>
            </div>
            
            <!-- Returns -->
            <div class="text-center">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Easy Returns</h3>
                <p class="text-sm text-gray-600">
                    Not satisfied? Return your items within 30 days for a full refund.
                </p>
            </div>
            
            <!-- Security -->
            <div class="text-center">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Secure Payment</h3>
                <p class="text-sm text-gray-600">
                    Your payment information is encrypted and processed securely.
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Confetti animation for successful order
function createConfetti() {
    const confettiCount = 50;
    const confettiColors = ['#ff6b6b', '#4ecdc4', '#45b7d1', '#96ceb4', '#ffeaa7'];
    
    for (let i = 0; i < confettiCount; i++) {
        const confetti = document.createElement('div');
        confetti.style.position = 'fixed';
        confetti.style.left = Math.random() * 100 + 'vw';
        confetti.style.top = '-10px';
        confetti.style.width = '10px';
        confetti.style.height = '10px';
        confetti.style.backgroundColor = confettiColors[Math.floor(Math.random() * confettiColors.length)];
        confetti.style.pointerEvents = 'none';
        confetti.style.zIndex = '9999';
        confetti.style.borderRadius = '50%';
        
        document.body.appendChild(confetti);
        
        const animation = confetti.animate([
            { 
                transform: 'translateY(-10px) rotate(0deg)',
                opacity: 1
            },
            { 
                transform: `translateY(100vh) rotate(${Math.random() * 360}deg)`,
                opacity: 0
            }
        ], {
            duration: 3000 + Math.random() * 2000,
            easing: 'cubic-bezier(0.5, 0, 0.5, 1)'
        });
        
        animation.onfinish = () => confetti.remove();
    }
}

// Trigger confetti on page load
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(createConfetti, 500);
});

// Order tracking functionality
function trackOrder() {
    // This would integrate with real shipping APIs
    alert('Order tracking will be available once your order ships. You\'ll receive an email with tracking details.');
}

// Print order functionality
function printOrder() {
    const printContent = `
        <html>
        <head>
            <title>Order Confirmation - {{ $order->order_number }}</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 20px; }
                .order-info { display: flex; justify-content: space-between; margin-bottom: 20px; }
                .items { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                .items th, .items td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                .items th { background-color: #f2f2f2; }
                .totals { text-align: right; }
                .total-line { margin: 5px 0; }
                .final-total { font-weight: bold; font-size: 1.2em; border-top: 2px solid #333; padding-top: 10px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>GelBlaster Pro</h1>
                <h2>Order Confirmation</h2>
                <p>Order #{{ $order->order_number }}</p>
            </div>
            
            <div class="order-info">
                <div>
                    <strong>Order Date:</strong> {{ $order->created_at->format('M j, Y') }}<br>
                    <strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}<br>
                    <strong>Order Status:</strong> {{ ucfirst($order->status) }}
                </div>
                <div>
                    <strong>Ship To:</strong><br>
                    {{ $order->shipping_full_name }}<br>
                    {{ $order->shipping_full_address }}
                </div>
            </div>
            
            <table class="items">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>SKU</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->product_sku }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->unit_price, 2) }}</td>
                        <td>${{ number_format($item->total_price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="totals">
                <div class="total-line">Subtotal: ${{ number_format($order->subtotal, 2) }}</div>
                <div class="total-line">Shipping: ${{ number_format($order->shipping_amount, 2) }}</div>
                <div class="total-line">Tax: ${{ number_format($order->tax_amount, 2) }}</div>
                <div class="total-line final-total">Total: ${{ number_format($order->total_amount, 2) }}</div>
            </div>
        </body>
        </html>
    `;
    
    const printWindow = window.open('', '_blank');
    printWindow.document.write(printContent);
    printWindow.document.close();
    printWindow.print();
}

// Social sharing
function shareOrder() {
    if (navigator.share) {
        navigator.share({
            title: 'Just ordered from GelBlaster Pro!',
            text: 'Check out my new gel blaster order',
            url: window.location.href
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        const shareText = 'Just ordered from GelBlaster Pro! Check out their amazing selection.';
        const shareUrl = encodeURIComponent(window.location.origin);
        
        const platforms = {
            twitter: `https://twitter.com/intent/tweet?text=${encodeURIComponent(shareText)}&url=${shareUrl}`,
            facebook: `https://www.facebook.com/sharer/sharer.php?u=${shareUrl}`,
            email: `mailto:?subject=Check out GelBlaster Pro&body=${encodeURIComponent(shareText + ' ' + window.location.origin)}`
        };
        
        const choice = prompt('Share on: 1) Twitter 2) Facebook 3) Email');
        const platformKeys = ['twitter', 'facebook', 'email'];
        const selectedPlatform = platformKeys[parseInt(choice) - 1];
        
        if (selectedPlatform && platforms[selectedPlatform]) {
            window.open(platforms[selectedPlatform], '_blank');
        }
    }
}

// Auto-redirect to order details after 30 seconds
setTimeout(() => {
    const redirect = confirm('Would you like to view your complete order details?');
    if (redirect) {
        window.location.href = '{{ route("orders.show", $order) }}';
    }
}, 30000);

// Newsletter signup suggestion
function suggestNewsletter() {
    const signup = confirm('Stay updated with our latest products and exclusive offers! Would you like to subscribe to our newsletter?');
    if (signup) {
        // This would trigger a newsletter signup modal or redirect
        alert('Newsletter signup feature coming soon! We\'ll keep your email on file for updates.');
    }
}

// Trigger newsletter suggestion after 10 seconds
setTimeout(suggestNewsletter, 10000);
</script>
@endpush
@endsection