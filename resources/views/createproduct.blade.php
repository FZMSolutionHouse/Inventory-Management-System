@extends('layouts.adminmaster')

@section('content')
    
    <div class="container">
        <a href="/product" class="back-btn">Back</a>
        <div class="header">
            <h1>Create Product</h1>
            <p>Form to create new Product</p>
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

       <form action="{{route('products.store')}}" method="POST" class="user-form">
        @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}" 
                       placeholder="Enter full name"
                       class="@error('name') is-invalid @enderror">
                @error('name')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="text">Detail</label>
                <input type="text" 
                       id="txt" 
                       name="detail" 
                       value="{{ old('detail') }}" 
                       placeholder="Enter Detail"
                       class="@error('detail') is-invalid @enderror">
                @error('detail')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="submit-btn">Create Product</button>
        </form>
    </div>

@endsection