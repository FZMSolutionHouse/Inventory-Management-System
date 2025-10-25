@extends('layouts.adminmaster')
@section('content')
    <div class="container">
        <div class="header">
            <h1>Create a Role's</h1>
            <p>Manage all Roles</p>
        </div>

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

        <a href="/createrole" class="create-user-btn">Create Role</a>
      
        <table class="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>Permissions</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                <tr>
                    <td>{{$role->id}}</td>
                    <td>{{$role->name}}</td>
                    <td>
                        @if ($role->permissions)
                            @foreach($role->permissions as $permission)
                                <span class="permission-badge">{{$permission->name}}</span>
                            @endforeach
                        @endif
                    </td>
                    <td class="action-buttons">
                        {{-- Show Button --}}
                        <a href="/showrole/{{$role->id}}" class="btn btn-show">Show</a>

                          {{-- Edit Button --}}
                         <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary">Edit</a>
                         
                        {{-- Delete Button --}}
                        <button onclick="deleteRole({{$role->id}})" class="btn btn-delete">
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

<script>
function deleteRole(id) {
    if (confirm('Are you sure you want to delete this role? This action cannot be undone.')) {
        // Create form
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = '/deleterole/' + id;
        
        // Add CSRF token
        let csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add method field for DELETE
        let methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        // Submit form
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection