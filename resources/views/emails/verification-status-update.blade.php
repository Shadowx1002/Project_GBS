<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Status Update</title>
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
        .status-box {
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .approved {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .rejected {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
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
            <h2>Age Verification Update</h2>
        </div>

        <div class="content">
            <h3>Hi {{ $verification->user->name }},</h3>
            
            @if($status === 'approved')
                <div class="status-box approved">
                    <h4>✓ Verification Approved!</h4>
                    <p>Your age verification has been successfully approved. You can now purchase gel blasters and accessories from our store.</p>
                </div>
                
                <p>You're all set! You can now browse our full catalog and make purchases. Thank you for your patience during the verification process.</p>
                
                <div style="text-align: center; margin: 30px 0;">
                    <a href="{{ route('products.index') }}" class="button">Start Shopping</a>
                </div>
            @else
                <div class="status-box rejected">
                    <h4>Verification Requires Attention</h4>
                    <p>We were unable to approve your age verification at this time.</p>
                </div>
                
                @if($rejectionReason)
                    <h4>Reason:</h4>
                    <p>{{ $rejectionReason }}</p>
                @endif
                
                <p>Please review the requirements and submit a new verification with a clear, valid government-issued ID showing your date of birth.</p>
                
                <div style="text-align: center; margin: 30px 0;">
                    <a href="{{ route('verification.show') }}" class="button">Resubmit Verification</a>
                </div>
            @endif
            
            <p>If you have any questions, please don't hesitate to contact our support team.</p>
        </div>

        <div class="footer">
            <h3>GelBlaster Pro</h3>
            <p>© {{ date('Y') }} GelBlaster Pro. All rights reserved.</p>
        </div>
    </div>
</body>
</html>