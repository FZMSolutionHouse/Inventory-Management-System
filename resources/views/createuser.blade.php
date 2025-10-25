@extends('layouts.adminmaster')

@section('content')
    

    <div class="container">
        <a href="/Premission" class="back-btn">← Back</a>
        <div class="header">
            <h1>Create User</h1>
            <p>Fill out the form below to create a new user account</p>
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

        <form action="{{ route('user.store') }}" method="POST" class="user-form">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}" 
                       placeholder="Enter full name"
                       class="@error('name') is-invalid @enderror">
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       placeholder="Enter email address"
                       class="@error('email') is-invalid @enderror">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       placeholder="Min 8 characters with letter, number & special character"
                       class="@error('password') is-invalid @enderror">
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <div class="roles-section">
                    <label for="roles">User Roles</label>
                    <div class="checkbox-container">
                        @foreach ($roles as $role)
                            <div class="checkbox-item">
                                <input type="checkbox" 
                                       name="roles[]" 
                                       id="role_{{ $role->id }}" 
                                       value="{{ $role->name }}">
                                <label for="role_{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <button type="submit" class="submit-btn">Create User Account</button>
        </form>
    </div>

    <script>
        // Add smooth form interactions
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.user-form');
            const submitBtn = document.querySelector('.submit-btn');
            
            // Add loading state on form submission
            form.addEventListener('submit', function(e) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Creating User...';
                
                // Re-enable after 3 seconds in case of error
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Create User Account';
                }, 3000);
            });

            // Add input validation feedback
            const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() && !this.classList.contains('is-invalid')) {
                        this.style.borderColor = '#28a745';
                    }
                });

                input.addEventListener('focus', function() {
                    if (this.style.borderColor === 'rgb(40, 167, 69)') {
                        this.style.borderColor = '#667eea';
                    }
                });
            });

            // Checkbox interaction improvements
            const checkboxItems = document.querySelectorAll('.checkbox-item');
            checkboxItems.forEach(item => {
                const checkbox = item.querySelector('input[type="checkbox"]');
                const label = item.querySelector('label');
                
                item.addEventListener('click', function(e) {
                    if (e.target !== checkbox) {
                        checkbox.checked = !checkbox.checked;
                        checkbox.dispatchEvent(new Event('change'));
                    }
                });
            });
        });
    </script>
@endsection