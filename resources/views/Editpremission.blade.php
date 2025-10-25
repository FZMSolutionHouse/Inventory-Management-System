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
        <a href="{{ route('Premission') }}" class="back-btn">Back</a>
        <div class="header">
            <h1>Edit User</h1>
            <p>Form to edit user information</p>
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
        <label for="email">Email</label>
        <input type="email" 
               id="email" 
               name="email" 
               value="{{ old('email', $user->email) }}" 
               placeholder="Enter email address"
               class="@error('email') is-invalid @enderror">
        @error('email')
            <span style="color: red; font-size: 12px;">{{ $message }}</span>
        @enderror
    </div>
    
    <div class="form-group">
        <label for="password">Password (Leave blank to keep current)</label>
        <input type="password" 
               id="password" 
               name="password" 
               placeholder="Enter new password (optional)"
               class="@error('password') is-invalid @enderror">
        @error('password')
            <span style="color: red; font-size: 12px;">{{ $message }}</span>
        @enderror
    </div>
    
    <button type="submit" class="submit-btn">Update User</button>
</form>

    </div>
</body>
</html>