<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Government Innovation Lab - Registration</title>
    <link rel="stylesheet" href="assets/css/registration.css">
    <style>
        /* Add these styles for success/error messages */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .alert-error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h3>Welcome to Government Innovation Lab<br>Inventory Management System</h3>
            <p>Create your account to get started</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Message -->
        @if($errors->has('error'))
            <div class="alert alert-error">
                {{ $errors->first('error') }}
            </div>
        @endif

        <form action="{{route('add')}}" method="POST" class="form-section">
            @csrf
            <h2 class="section-title">Registration</h2>
            
            <div class="form-group">
                <label for="fullName">Full Name</label>
                <input type="text" value="{{old('fullname')}}" class="@error('fullname') is-invalid @enderror" id="fullName" name="fullname" placeholder="Enter your full name" required>
                <span>
                    @error('fullname')
                        {{$message}}
                    @enderror
                </span>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" value="{{old('email')}}" class="@error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter your email address" required>
                <span>
                    @error('email')
                        {{$message}}
                    @enderror
                </span>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" class="@error('password') is-invalid @enderror" name="password" placeholder="Create a password" required>
                <span>
                    @error('password')
                        {{$message}}
                    @enderror
                </span>
            </div>

            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" class="@error('confirmedPassword') is-invalid @enderror" name="confirmedPassword" placeholder="Confirm your password" required>
                <span>
                    @error('confirmedPassword')
                        {{$message}}
                    @enderror
                </span>
            </div>

            <button type="submit" class="register-btn">Register</button>
        </form>

        <div class="divider">
            <span>OR CONTINUE WITH</span>
        </div>

        <button type="button" class="google-btn">
            <svg class="google-icon" viewBox="0 0 24 24">
                <path fill="#4285f4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34a853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#fbbc05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#ea4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            Continue with Google
        </button>
        <div class="terms">
            After registering, your self <a href="/login">Login Here</a>.
        </div>
        <div class="terms">
            By registering, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
        </div>
    </div>
</body>
</html>