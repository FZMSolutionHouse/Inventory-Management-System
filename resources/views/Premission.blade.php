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
                                <span class="role-tag">{{ $roleName }}</span>
                            @endforeach
                        @endif
                    </td>
                    <td data-label="ACTION">
                        <div class="action-buttons">
                           
                            <button 
                                class="btn btn-show"
                                data-user-id="{{$user->id}}"
                                data-user-name="{{$user->name}}"
                                data-user-email="{{$user->email}}"
                                data-user-roles="{{ !empty($user->getRoleNames()) ? $user->getRoleNames()->implode(', ') : '' }}"
                                onclick="showUserModal(this)">
                                Show
                            </button>
                       
                            <button 
                                class="btn btn-edit"
                                data-user-id="{{$user->id}}"
                                data-user-name="{{$user->name}}"
                                data-user-email="{{$user->email}}"
                                onclick="showEditModal(this)">
                                Edit
                            </button>
                           
                           
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

    <!-- Show User Modal -->
    <div id="userModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2>User Details</h2>
                <button class="modal-close" onclick="closeUserModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="user-detail-row">
                    <strong>ID:</strong>
                    <span id="modalUserId"></span>
                </div>
                <div class="user-detail-row">
                    <strong>Name:</strong>
                    <span id="modalUserName"></span>
                </div>
                <div class="user-detail-row">
                    <strong>Email:</strong>
                    <span id="modalUserEmail"></span>
                </div>
                <div class="user-detail-row">
                    <strong>Roles:</strong>
                    <span id="modalUserRoles"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="closeUserModal()" class="btn-modal-close">Close</button>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editModal" class="modal-overlay">
        <div class="modal-content modal-content-large">
            <div class="modal-header">
                <h2>Edit User</h2>
                <button class="modal-close" onclick="closeEditModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="POST" class="user-form">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="edit_name">Name</label>
                        <input type="text" 
                               id="edit_name" 
                               name="name" 
                               placeholder="Enter full name"
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" 
                               id="edit_email" 
                               name="email" 
                               placeholder="Enter email address"
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_password">Password (Leave blank to keep current)</label>
                        <input type="password" 
                               id="edit_password" 
                               name="password" 
                               placeholder="Enter new password (optional)">
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" onclick="closeEditModal()" class="btn-modal-cancel">Cancel</button>
                        <button type="submit" class="btn-modal-submit">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
// Show User Modal
function showUserModal(button) {
    const id = button.getAttribute('data-user-id');
    const name = button.getAttribute('data-user-name');
    const email = button.getAttribute('data-user-email');
    const roles = button.getAttribute('data-user-roles');
    
    document.getElementById('modalUserId').textContent = id;
    document.getElementById('modalUserName').textContent = name;
    document.getElementById('modalUserEmail').textContent = email;
    document.getElementById('modalUserRoles').textContent = roles || 'No roles assigned';
    document.getElementById('userModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeUserModal() {
    document.getElementById('userModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Edit User Modal
function showEditModal(button) {
    const id = button.getAttribute('data-user-id');
    const name = button.getAttribute('data-user-name');
    const email = button.getAttribute('data-user-email');
    
    // Set form action
    document.getElementById('editUserForm').action = `/user/update/${id}`;
    
    // Populate form fields
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_password').value = '';
    
    // Show modal
    document.getElementById('editModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    // Reset form
    document.getElementById('editUserForm').reset();
}

// Close modals when clicking outside
window.onclick = function(event) {
    const userModal = document.getElementById('userModal');
    const editModal = document.getElementById('editModal');
    
    if (event.target === userModal) {
        closeUserModal();
    }
    if (event.target === editModal) {
        closeEditModal();
    }
}

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeUserModal();
        closeEditModal();
    }
});

// Delete User
function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = `/permission/${id}`;
        
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