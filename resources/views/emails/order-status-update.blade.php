<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Update - {{ $order->order_number }}</title>
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
        .status-update {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>GelBlaster Pro</h1>
            <h2>Order Status Update</h2>
        </div>

        <div class="content">
            <h3>Hi {{ $order->shipping_first_name }},</h3>
            
            <p>Your order status has been updated!</p>

            <div class="status-update">
                <h4>Order #{{ $order->order_number }}</h4>
                <p><strong>Status changed from:</strong> {{ ucfirst($oldStatus) }}</p>
                <p><strong>To:</strong> {{ ucfirst($newStatus) }}</p>
                
                @if($newStatus === 'shipped')
                    <p>Your order has been shipped and is on its way to you!</p>
                    @if($order->tracking_number)
                        <p><strong>Tracking Number:</strong> {{ $order->tracking_number }}</p>
                    @endif
                @elseif($newStatus === 'delivered')
                    <p>Your order has been delivered. We hope you enjoy your new gel blaster!</p>
                @endif
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('orders.show', $order) }}" class="button">View Order Details</a>
            </div>

            <p>If you have any questions about your order, please don't hesitate to contact our customer support team.</p>
            
            <p>Thank you for choosing GelBlaster Pro!</p>
        </div>

        <div class="footer">
            <h3>GelBlaster Pro</h3>
            <p>© {{ date('Y') }} GelBlaster Pro. All rights reserved.</p>
        </div>
    </div>
</body>
</html>