<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show User</title>
    <link rel="stylesheet" href="{{ asset('assets/css/createstyle.css') }}">
</head>
<body>
    <div class="container">
        
        <a href="{{ route('products.index') }}" class="back-btn">Back</a>
        <div class="header">
            <h1>Show Product</h1>
            <p>Show Product Information</p>
        </div>
        <p><strong>Name:</strong>{{$product->name}}</p>
        <p><strong>detail:</strong>{{$product->detail}}</p>
    </div>
</body>
</html>