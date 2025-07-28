<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - {{ $order->order_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }
        .content {
            padding: 30px;
        }
        .order-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .items-table th,
        .items-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .items-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .totals {
            text-align: right;
            margin: 20px 0;
        }
        .total-line {
            margin: 8px 0;
        }
        .final-total {
            font-size: 1.2em;
            font-weight: bold;
            color: #667eea;
            border-top: 2px solid #667eea;
            padding-top: 10px;
        }
        .button {
            display: inline-block;
            background-color: #667eea;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px 0;
        }
        .footer {
            background-color: #333;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .social-links {
            margin: 20px 0;
        }
        .social-links a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>GelBlaster Pro</h1>
            <h2>Order Confirmation</h2>
            <p>Thank you for your purchase!</p>
        </div>

        <!-- Content -->
        <div class="content">
            <h3>Hi {{ $order->shipping_first_name }},</h3>
            
            <p>Your order has been successfully placed and will be processed within 1-2 business days. You'll receive another email when your items ship.</p>

            <!-- Order Information -->
            <div class="order-info">
                <h4>Order Details</h4>
                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('M j, Y \a\t g:i A') }}</p>
                <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                <p><strong>Estimated Delivery:</strong> {{ $order->estimated_delivery }}</p>
            </div>

            <!-- Order Items -->
            <h4>Items Ordered</h4>
            <table class="items-table">
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
                    @foreach($items as $item)
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

            <!-- Totals -->
            <div class="totals">
                <div class="total-line">Subtotal: ${{ number_format($order->subtotal, 2) }}</div>
                <div class="total-line">Shipping: ${{ number_format($order->shipping_amount, 2) }}</div>
                <div class="total-line">Tax: ${{ number_format($order->tax_amount, 2) }}</div>
                <div class="total-line final-total">Total: ${{ number_format($order->total_amount, 2) }}</div>
            </div>

            <!-- Shipping Address -->
            <h4>Shipping Address</h4>
            <div class="order-info">
                <p>{{ $order->shipping_full_name }}</p>
                <p>{{ $order->shipping_address_line_1 }}</p>
                @if($order->shipping_address_line_2)
                    <p>{{ $order->shipping_address_line_2 }}</p>
                @endif
                <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                <p>{{ $order->shipping_country }}</p>
            </div>

            <!-- Action Button -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('orders.show', $order) }}" class="button">View Order Details</a>
            </div>

            <!-- Safety Notice -->
            <div style="background-color: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 6px; margin: 20px 0;">
                <h4 style="color: #856404; margin: 0 0 10px 0;">Important Safety Information</h4>
                <p style="color: #856404; margin: 0; font-size: 14px;">
                    Please ensure you follow all safety guidelines when using gel blasters. Always wear appropriate protective gear and use only in designated areas. Remember that age verification was required for this purchase.
                </p>
            </div>

            <p>If you have any questions about your order, please don't hesitate to contact our customer support team.</p>
            
            <p>Thank you for choosing GelBlaster Pro!</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <h3>GelBlaster Pro</h3>
            <p>Your trusted source for premium gel blasters and accessories</p>
            
            <div class="social-links">
                <a href="#">Facebook</a> |
                <a href="#">Twitter</a> |
                <a href="#">Instagram</a>
            </div>
            
            <p style="font-size: 12px; color: #ccc;">
                This email was sent to {{ $order->shipping_email }}. 
                <br>© {{ date('Y') }} GelBlaster Pro. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>