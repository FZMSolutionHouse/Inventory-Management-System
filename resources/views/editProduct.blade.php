<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="{{ asset('assets/css/createstyle.css') }}">
</head>
<body>
    <div class="container">
        <a href="{{ route('product') }}" class="back-btn">Back</a>
        <div class="header">
            <h1>Edit Product</h1>
            <p>Product information</p>
        </div>
        
        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach 
            </div>
        @endif

<form action="{{ route('user.update', $user->id) }}" method="POST" class="user-form">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" 
               id="name" 
               name="name" 
               value="{{ old('name', $user->name) }}" 
               placeholder="Enter full name"
               class="@error('name') is-invalid @enderror">
        @error('name')
            <span style="color: red; font-size: 12px;">{{ $message }}</span>
        @enderror
    </div>
    
    <div class="form-group">
        <label for="Detail">Email</label>
        <input type="text" 
               id="txt" 
               name="detail" 
               value="{{ old('detail', $user->detail) }}" 
               placeholder="Enter Detail"
               class="@error('detail') is-invalid @enderror">
        @error('detail')
            <span style="color: red; font-size: 12px;">{{ $message }}</span>
        @enderror
    </div>
    <button type="submit" class="submit-btn">Update Product</button>
</form>

    </div>
</body>
</html>