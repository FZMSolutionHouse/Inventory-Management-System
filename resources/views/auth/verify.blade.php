<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - Inventory Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .verify-container {
            max-width: 450px;
            width: 100%;
        }
        .card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1), 0 2px 8px rgba(0,0,0,0.06);
        }
        .card-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 25px 30px;
            text-align: center;
        }
        .card-header h3 {
            font-size: 22px;
            margin: 0;
        }
        .card-header p {
            font-size: 14px;
            margin: 5px 0 0 0;
            opacity: 0.95;
        }
        .card-body {
            padding: 30px;
        }
        .email-icon {
            font-size: 50px;
            color: #10b981;
            margin-bottom: 15px;
        }
        .text-center h5 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .text-center p {
            font-size: 14px;
            line-height: 1.5;
        }
        .verification-code-input {
            font-size: 22px;
            letter-spacing: 8px;
            text-align: center;
            font-weight: bold;
            padding: 12px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
        }
        .verification-code-input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25);
        }
        .btn-verify {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            padding: 12px;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 8px;
        }
        .btn-verify:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }
        .info-box {
            background-color: #d1fae5;
            border-left: 4px solid #10b981;
            padding: 12px 15px;
            margin-top: 20px;
            border-radius: 6px;
            font-size: 13px;
        }
        .btn-link {
            color: #059669;
            font-weight: 500;
        }
        .btn-link:hover {
            color: #047857;
        }
        .text-secondary {
            color: #6b7280 !important;
        }
        hr {
            margin: 20px 0;
            opacity: 0.1;
        }
        .alert {
            font-size: 14px;
            padding: 12px 15px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="verify-container">
        <div class="card">
            <div class="card-header">
                <h3>
                    <i class="fas fa-shield-alt"></i> Email Verification
                </h3>
                <p>Two-Step Authentication</p>
            </div>
            <div class="card-body">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Error Message -->
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Email Icon and Instructions -->
                <div class="text-center mb-3">
                    <i class="fas fa-envelope-open-text email-icon"></i>
                    <h5>Check Your Email</h5>
                    <p class="text-muted">We've sent a 6-digit verification code to your email address. Please enter it below to complete your login.</p>
                </div>

                <!-- Verification Form -->
                <form method="POST" action="{{ route('verification.verify') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="verification_code" class="form-label fw-bold">Verification Code</label>
                        <input type="text" 
                               class="form-control verification-code-input @error('verification_code') is-invalid @enderror" 
                               id="verification_code" 
                               name="verification_code" 
                               placeholder="000000"
                               maxlength="6"
                               required 
                               autofocus>
                        
                        @error('verification_code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-verify">
                            <i class="fas fa-check-circle"></i> Verify Code
                        </button>
                    </div>
                </form>

                <hr>

                <!-- Resend Code -->
                <div class="text-center">
                    <p class="text-muted mb-2" style="font-size: 14px;">Didn't receive the code?</p>
                    <form method="POST" action="{{ route('verification.resend') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link text-decoration-none p-0">
                            <i class="fas fa-redo"></i> Resend Code
                        </button>
                    </form>
                </div>

                <!-- Back to Login -->
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="btn btn-link text-secondary text-decoration-none p-0">
                        <i class="fas fa-arrow-left"></i> Back to Login
                    </a>
                </div>

                <!-- Info Box -->
                <div class="info-box">
                    <i class="fas fa-info-circle"></i> 
                    <strong>Note:</strong> The verification code will expire in 10 minutes for security purposes.
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Auto-format verification code input -->
    <script>
        document.getElementById('verification_code').addEventListener('input', function(e) {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Auto-submit when 6 digits are entered (optional)
            if(this.value.length === 6) {
                // You can uncomment the line below to auto-submit
                // this.form.submit();
            }
        });

        // Prevent paste of non-numeric content
        document.getElementById('verification_code').addEventListener('paste', function(e) {
            e.preventDefault();
            var pastedData = e.clipboardData.getData('text');
            var numericData = pastedData.replace(/[^0-9]/g, '');
            this.value = numericData.substring(0, 6);
        });
    </script>
</body>
</html>