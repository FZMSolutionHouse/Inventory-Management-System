@extends('layouts.adminmaster')

@section('content')
    <div class="container">
        {{-- Success/Error Messages --}}
@if(session('success'))
    <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
        {{ session('error') }}
    </div>
@endif
        <div class="header">
            <h1>Add GIL Product</h1>
            <p>Product which are created to represent GIL</p>
        </div>
    
        <a href="/createproduct" class="create-user-btn">Create Product</a>
        
        <table class="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>Detail</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td data-label="ID">{{$product->id}}</td>
                    <td data-label="NAME">{{$product->name}}</td>
                    <td data-label="Detail">{{$product->detail}}</td>
                    <td data-label="ACTION">
                        <div class="action-buttons">
                            {{-- Show Button --}}
                            <button 
                                class="btn btn-show"
                                data-product-id="{{$product->id}}"
                                data-product-name="{{$product->name}}"
                                data-product-detail="{{$product->detail}}"
                                onclick="showProductModal(this)">
                                Show
                            </button>
                            
                            {{-- Edit Button --}}
                            <button 
                                class="btn btn-edit"
                                data-product-id="{{$product->id}}"
                                data-product-name="{{$product->name}}"
                                data-product-detail="{{$product->detail}}"
                                onclick="showEditProductModal(this)">
                                Edit
                            </button>
                       
                            {{-- Delete Button --}}
                            <button onclick="deleteProduct('{{ $product->id }}')" class="btn btn-delete">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Show Product Modal -->
    <div id="productModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Product Details</h2>
                <button class="modal-close" onclick="closeProductModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="user-detail-row">
                    <strong>ID:</strong>
                    <span id="modalProductId"></span>
                </div>
                <div class="user-detail-row">
                    <strong>Name:</strong>
                    <span id="modalProductName"></span>
                </div>
                <div class="user-detail-row">
                    <strong>Detail:</strong>
                    <span id="modalProductDetail"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="closeProductModal()" class="btn-modal-close">Close</button>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div id="editProductModal" class="modal-overlay">
        <div class="modal-content modal-content-large">
            <div class="modal-header">
                <h2>Edit Product</h2>
                <button class="modal-close" onclick="closeEditProductModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editProductForm" method="POST" class="user-form">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="edit_product_name">Name</label>
                        <input type="text" 
                               id="edit_product_name" 
                               name="name" 
                               placeholder="Enter product name"
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_product_detail">Detail</label>
                        <input type="text" 
                               id="edit_product_detail" 
                               name="detail" 
                               placeholder="Enter product detail"
                               required>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" onclick="closeEditProductModal()" class="btn-modal-cancel">Cancel</button>
                        <button type="submit" class="btn-modal-submit">Update Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
// Show Product Modal
function showProductModal(button) {
    const id = button.getAttribute('data-product-id');
    const name = button.getAttribute('data-product-name');
    const detail = button.getAttribute('data-product-detail');
    
    document.getElementById('modalProductId').textContent = id;
    document.getElementById('modalProductName').textContent = name;
    document.getElementById('modalProductDetail').textContent = detail;
    document.getElementById('productModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeProductModal() {
    document.getElementById('productModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Edit Product Modal
function showEditProductModal(button) {
    const id = button.getAttribute('data-product-id');
    const name = button.getAttribute('data-product-name');
    const detail = button.getAttribute('data-product-detail');
    
    // Set form action
    document.getElementById('editProductForm').action = `/Product/${id}`;
    
    // Populate form fields
    document.getElementById('edit_product_name').value = name;
    document.getElementById('edit_product_detail').value = detail;
    
    // Show modal
    document.getElementById('editProductModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeEditProductModal() {
    document.getElementById('editProductModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    // Reset form
    document.getElementById('editProductForm').reset();
}

// Close modals when clicking outside
window.onclick = function(event) {
    const productModal = document.getElementById('productModal');
    const editProductModal = document.getElementById('editProductModal');
    
    if (event.target === productModal) {
        closeProductModal();
    }
    if (event.target === editProductModal) {
        closeEditProductModal();
    }
}

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeProductModal();
        closeEditProductModal();
    }
});

// Delete Product
function deleteProduct(id) {
    if (confirm('Are you sure you want to delete this product?')) {
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = `/Product/${id}`;
        
        let csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        let methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection