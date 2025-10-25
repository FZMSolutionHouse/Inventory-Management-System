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
        <a href="{{ route('Premission') }}" class="back-btn">Back</a>
        <div class="header">
            <h1>Show User</h1>
            <p>Show User information</p>
        </div>
        <p><strong>Name:</strong>{{$user->name}}</p>
        <p><strong>Email:</strong>{{$user->email}}</p>
    </div>
</body>
</html>