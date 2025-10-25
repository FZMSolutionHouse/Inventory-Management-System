<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System - Login</title>
    <link rel="stylesheet" href="assets/css/loginstyle.css">
</head>
<body>
    <div class="container">
        <div class="login-card">
            <h1 class="title">Inventory Management System</h1>
            <p class="subtitle">Sign in to access your dashboard</p>
            
            <form class="login-form"  action="{{route ('login')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label"  @error ('email') is-invalid @enderror>Email</label>
                    <input 
                    value="{{old('email')}}"
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="Enter your email"
                    >
                    <span>
                        @error('email')
                        {{$message}}
                        @enderror
                    </span>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label" @error ('password') is -invalid @enderror>Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Enter your password"
                    >
                    <span>
                        @error('password')
                      {{$message}}
                        @enderror
                    </span>
                </div>
                
                <button type="submit" class="sign-in-btn">Sign In</button>
            </form>
            
            <div class="register-link">
                <p>Don't have an account? <a href="/registration">Create a new account</a></p>
            </div>
        </div>
    </div>
</body>
</html>