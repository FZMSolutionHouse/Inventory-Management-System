@extends('layouts.adminmaster')

@section('content')  
    <!-- Header -->
    <header class="gil-product-header">
        <div class="gil-product-container">
            <div class="gil-product-header-content">
                <div class="gil-product-header-left">
                    <div class="gil-product-logo">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="gil-product-header-text">
                        <h2>Product by GIL Employee's</h2>
                        <p>Track products and their locations</p>
                    </div>
                </div>
                <button class="gil-product-btn-add" id="openModalBtn">
                    <i class="fas fa-plus"></i>
                    Add New Product
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="gil-product-main-content">
        <div class="gil-product-container">
            
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success" style="padding: 15px; background: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" style="padding: 15px; background: #f8d7da; color: #721c24; border-radius: 5px; margin-bottom: 20px;">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Products Grid -->
            <div class="gil-product-products-grid">
                @forelse($products as $product)
                    <!-- Product Card -->
                    <div class="gil-product-card">
                        <div class="gil-product-card-header">
                            <div class="gil-product-title-section">
                                <i class="fas fa-box gil-product-icon"></i>
                                <h3>{{ $product->product_name }}</h3>
                            </div>
                            <div class="gil-product-location-badge">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Location</span>
                            </div>
                        </div>
                        <div class="gil-product-employee-info">
                            <i class="fas fa-user"></i>
                            <span>{{ $product->name }}</span>
                        </div>
                        <p class="gil-product-description">
                            {{ $product->description }}
                        </p>
                        <div class="gil-product-coordinates" style="margin: 10px 0; font-size: 12px; color: #666;">
                            <i class="fas fa-globe"></i>
                            Lat: {{ $product->latitude }}, Long: {{ $product->longitude }}
                        </div>
                        <button class="gil-product-btn-view-location" onclick="viewLocation({{ $product->latitude }}, {{ $product->longitude }})">
                            <i class="fas fa-map-marker-alt"></i>
                            View Location on Map
                        </button>
                    </div>
                @empty
                    <!-- No Products Message -->
                    <div style="grid-column: 1/-1; text-align: center; padding: 40px;">
                        <i class="fas fa-box-open" style="font-size: 48px; color: #ccc;"></i>
                        <p style="margin-top: 20px; color: #666;">No products found. Add your first product!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    <!-- Include Modal -->
    @include('addlocationproduct')

    <script>
        function viewLocation(lat, lng) {
            // Open Google Maps with the coordinates
            window.open(`https://www.google.com/maps?q=${lat},${lng}`, '_blank');
        }
    </script>
@endsection