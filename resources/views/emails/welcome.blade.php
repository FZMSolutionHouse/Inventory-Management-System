<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $sub }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h2 {
            color: #2c5aa0;
            margin: 0;
            font-size: 28px;
        }
        .content {
            margin: 20px 0;
        }
        .content p {
            margin-bottom: 15px;
        }
        .button {
            display: inline-block;
            padding: 15px 30px;
            background-color: #2c5aa0;
            color: white !important;
            text-decoration: none;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #1e3f73;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>🎉 Congratulations & Welcome!</h2>
        </div>
        <div class="content">
            <p>Dear <strong>{{ $user->name }}</strong>,</p>
            <p>Welcome to the <strong>Government Innovation Lab</strong>!  
            We are excited to have you on board with our <strong>Inventory Management System</strong>.</p>
            
            <p>This platform will help you manage resources, track inventory efficiently, and ensure smooth operations.</p>
            <p>To get started, click below:</p>
            
            <a href="{{ url('/login') }}" class="button">Access Your Dashboard</a>
            <p>If you have any questions, our support team is always here to assist you.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Government Innovation Lab | Inventory Management System</p>
        </div>
    </div>
</body>
</html>