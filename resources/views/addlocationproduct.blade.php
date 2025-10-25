<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/addlocationproduct.css">
    <title>Document</title>
</head>
<body>
    
<div class="gil-modal-overlay" id="productModal">
    <div class="gil-modal-container">
        <div class="gil-modal-header">
            <h2>Add Product Details</h2>
            <button class="gil-modal-close" id="closeModalBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{route('locationproduct.store')}}" method="POST">
            @csrf
            <div class="gil-form-group">
                <label for="employeeName">Employee Name</label>
                <input class="@error('name')is-invalid @enderror" type="text" value="{{ old('name') }}" id="employeeName" name="name" placeholder="Enter your name" required>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="gil-form-group">
                <label for="productName">Product Name</label>
                <input class="@error('product_name')is-invalid @enderror" type="text" value="{{ old('product_name') }}" id="productName" name="product_name" placeholder="Enter product name" required>
                @error('product_name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="gil-form-group">
                <label for="productDescription">Product Description</label>
                <textarea class="@error('description')is-invalid @enderror" id="productDescription" name="description" placeholder="Describe the product..." rows="4" required>{{ old('description') }}</textarea>
                @error('description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="gil-form-row">
                <div class="gil-form-group">
                    <label for="latitude">Latitude</label>
                    <input class="@error('latitude')is-invalid @enderror" type="text" value="{{ old('latitude') }}" id="latitude" name="latitude" placeholder="e.g., 40.7128" required>
                    @error('latitude')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="gil-form-group">
                    <label for="longitude">Longitude</label>
                    <input class="@error('longitude')is-invalid @enderror" type="text" value="{{ old('longitude') }}" id="longitude" name="longitude" placeholder="e.g., -74.0060" required>
                    @error('longitude')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="gil-modal-actions">
                <button type="button" class="gil-btn-cancel" id="cancelBtn">Cancel</button>
                <button type="submit" class="gil-btn-submit">Add Product</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Modal functionality
    const modal = document.getElementById('productModal');
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const form = document.getElementById('productForm');

    // Open modal
    if (openBtn) {
        openBtn.addEventListener('click', () => {
            modal.classList.add('active');
        });
    }

    // Close modal
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            modal.classList.remove('active');
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', () => {
            modal.classList.remove('active');
        });
    }

    // Close modal when clicking outside
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    });
</script>
</body>
</html>