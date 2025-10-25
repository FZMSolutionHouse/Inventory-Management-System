@extends('layouts.adminmaster')

@section('content')
    <div class="container">
        <div class="header">
            <h1>Create User's</h1>
            <p>Manage all your users</p>
        </div>
      
       
        <a href="/createuser" class="create-user-btn">Create User</a>
      

        <table class="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>EMAIL</th>
                    <th>Roles</th>
                    <th>ACTION</th>
                </tr>
            </thead>
           
            <tbody>
                @foreach ($createuser as $user)
                <tr>
                    <td data-label="ID">{{$user->id}}</td>
                    <td data-label="NAME">{{$user->name}}</td>
                    <td data-label="EMAIL">{{$user->email}}</td>
                    <td data-label="Roles">
                        @if(!empty($user->getRoleNames()))
                            @foreach($user->getRoleNames() as $roleName)
                                {{-- Using the 'role-tag' class for better styling --}}
                                <span class="role-tag">{{ $roleName }}</span>
                            @endforeach
                        @endif
                    </td>
                    <td data-label="ACTION">
                        <div class="action-buttons">
                           
                            <a href="{{ route('Premssion.show', $user->id) }}" class="btn btn-show">Show</a>
                       

                            
                            <a href="{{ route('EditPremission', $user->id) }}" class="btn btn-edit">Edit</a>    
                           
                           
                            <button onclick="deleteUser({{$user->id}})" class="btn btn-delete">
                                Delete
                            </button>
                          
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

<script>
function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
        // Create a form dynamically to send DELETE request
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = `/permission/${id}`;
        
        // Add CSRF token
        let csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add DELETE method
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