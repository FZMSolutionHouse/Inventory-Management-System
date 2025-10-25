@extends('layouts.adminmaster')

@section('content')
    <div class="container">
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
                    <td>{{$product->id}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->detail}}</td>
                    <td class="action-buttons">
                      <td class="action-buttons">
    {{-- This is the link that takes you to the show page --}}
                        
                       <a href="{{ route('product.show', ['id' => $product->id]) }}" class="btn btn-show">Show</a>
                      
                        <a href="" class="btn btn-edit">Edit</a>
                   
                        {{-- Change 1: Call deleteUser and pass only the product ID --}}
                    
                        <button onclick="deleteUser('{{ $product->id }}')" class="btn btn-delete">
                            Delete
                        </button>
                    </td>
                </tr>
                   @endforeach
            </tbody>
        </table>
    </div>

<script>
// Make sure the function name matches the one in onclick
function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
        // Create a form dynamically to send DELETE request
        let form = document.createElement('form');
        form.method = 'POST';
        
        // Change 2: Manually construct the URL in JavaScript
        // This avoids the server-side Blade error.
        form.action = `/Product/${id}`;
        
        // Add CSRF token
        let csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}'; // This is correct
        form.appendChild(csrfToken);
        
        // Add DELETE method spoofing
        let methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        // Submit the form
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection