<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GIL Inventory System - Edit Item</title>
    <link rel="stylesheet" href="{{ asset('assets/css/addinventory.css') }}">
  
   
</head>
<body>
    <div class="overlay">
        <div class="modal">
            <button class="close-btn" onclick="goBack()">&times;</button>
            
            <h2 class="modal-title">GIL Edit Inventory Item</h2>
            <p class="modal-subtitle">GIL inventory system - Update the details below to modify the item in your inventory.</p>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form id="inventoryForm" action="{{ route('update_data', $data->id) }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="itemName">Item Name</label>
                        <input type="text" value="{{ $data->itemName }}" id="itemName" name="itemName" class="form-input @error('itemName') is-invalid @enderror">
                        <span>
                            @error('itemName')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="category">Category</label>
                        <input type="text" value="{{ $data->category }}" id="category" name="category" class="form-input @error('category') is-invalid @enderror">
                        <span>
                            @error('category')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="quantity">Quantity</label>
                        <input type="number" value="{{ $data->quantity }}" id="quantity" name="quantity" class="form-input @error('quantity') is-invalid @enderror">
                        <span>
                            @error('quantity')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="minimumStock">Minimum Stock</label>
                        <input type="number" value="{{ $data->minimumStock }}" id="minimumStock" name="minimumStock" class="form-input @error('minimumStock') is-invalid @enderror">
                        <span>
                            @error('minimumStock')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="price">Price</label>
                        <input type="number" step="0.01" value="{{ $data->price }}" id="price" name="price" class="form-input @error('price') is-invalid @enderror">
                        <span>
                            @error('price')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="supplier">Supplier</label>
                        <input type="text" value="{{ $data->supplier }}" id="supplier" name="supplier" class="form-input @error('supplier') is-invalid @enderror">
                        <span>
                            @error('supplier')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>
                
                <div class="button-group">
                    <button type="button" class="btn btn-cancel" onclick="goBack()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Item</button>
                </div>
            </form>
        </div>
    </div>

    
    <script>
        function goBack() {
            window.location.href = '/records';
        }

        // Auto-focus on the first input when page loads
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('itemName').focus();
        });
    </script>
</body>
</html>