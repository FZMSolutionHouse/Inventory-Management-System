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
                    <td data-label="ID">{{$role->id}}</td>
                    <td data-label="NAME">{{$role->name}}</td>
                    <td data-label="Permissions">
                        @if ($role->permissions)
                            @foreach($role->permissions as $permission)
                                <span class="permission-badge">{{$permission->name}}</span>
                            @endforeach
                        @endif
                    </td>
                    <td data-label="ACTION">
                        <div class="action-buttons">
                            {{-- Show Button --}}
                            <button 
                                class="btn btn-show"
                                data-role-id="{{$role->id}}"
                                data-role-name="{{$role->name}}"
                                data-role-created="{{$role->created_at->format('M d, Y')}}"
                                data-role-permissions="{{ $role->permissions->pluck('name')->implode('|||') }}"
                                data-role-permissions-count="{{$role->permissions->count()}}"
                                onclick="showRoleModal(this)">
                                Show
                            </button>

                            {{-- Edit Button --}}
                            <button 
                                class="btn btn-edit"
                                data-role-id="{{$role->id}}"
                                data-role-name="{{$role->name}}"
                                data-role-permission-ids="{{ $role->permissions->pluck('id')->implode(',') }}"
                                onclick="showEditRoleModal(this)">
                                Edit
                            </button>
                             
                            {{-- Delete Button --}}
                            <button onclick="deleteRole({{$role->id}})" class="btn btn-delete">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Show Role Modal -->
    <div id="roleModal" class="modal-overlay">
        <div class="modal-content modal-content-role">
            <div class="modal-header modal-header-role">
                <div>
                    <h2 id="modalRoleName" style="margin: 0; color: white;"></h2>
                    <p style="margin: 5px 0 0 0; opacity: 0.9; color: white; font-size: 14px;">Complete role information and assigned permissions</p>
                    <span id="modalRoleIdBadge" class="role-id-badge-modal"></span>
                </div>
                <button class="modal-close modal-close-white" onclick="closeRoleModal()">&times;</button>
            </div>
            
            <div class="modal-body" style="padding: 30px;">
                <!-- Info Cards Grid -->
                <div class="role-info-grid-modal">
                    <div class="role-info-card-modal">
                        <div class="role-info-label-modal">Role Name</div>
                        <div class="role-info-value-modal" id="modalRoleNameValue"></div>
                    </div>
                    
                    <div class="role-info-card-modal">
                        <div class="role-info-label-modal">Total Permissions</div>
                        <div class="role-info-value-modal" id="modalRolePermCount"></div>
                    </div>
                    
                    <div class="role-info-card-modal">
                        <div class="role-info-label-modal">Created At</div>
                        <div class="role-info-value-modal" id="modalRoleCreated" style="font-size: 20px;"></div>
                    </div>
                </div>

                <!-- Permissions Section -->
                <div class="role-permissions-section-modal">
                    <div class="role-section-title-modal">Assigned Permissions</div>
                    
                    <div class="role-stats-bar-modal">
                        <div style="text-align: center; width: 100%;">
                            <div class="role-stat-number-modal" id="modalRolePermCountLarge"></div>
                            <div class="role-stat-label-modal">Total Permissions</div>
                        </div>
                    </div>
                    
                    <div id="modalPermissionsGrid" class="role-permissions-grid-modal">
                        <!-- Permissions will be inserted here -->
                    </div>
                    
                    <div id="modalEmptyPermissions" class="role-empty-state-modal" style="display: none;">
                        <p>No permissions assigned to this role yet.</p>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button onclick="closeRoleModal()" class="btn-modal-close">Close</button>
            </div>
        </div>
    </div>

    <!-- Edit Role Modal -->
    <div id="editRoleModal" class="modal-overlay">
        <div class="modal-content modal-content-edit-role">
            <div class="modal-header modal-header-role">
                <div>
                    <h2 style="margin: 0; color: white;">Edit Role</h2>
                    <p style="margin: 5px 0 0 0; opacity: 0.9; color: white; font-size: 14px;">Update role name and permissions</p>
                </div>
                <button class="modal-close modal-close-white" onclick="closeEditRoleModal()">&times;</button>
            </div>
            
            <form id="editRoleForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-body" style="padding: 30px;">
                    {{-- Role Name Input --}}
                    <div class="form-group-modal">
                        <label class="form-label-modal" for="edit_role_name">Role Name</label>
                        <input type="text" 
                               class="form-input-modal" 
                               id="edit_role_name" 
                               name="name" 
                               placeholder="Enter role name"
                               required>
                    </div>

                    {{-- Permissions Checkboxes --}}
                    <div class="permissions-section-edit">
                        <label class="form-label-modal">Select Permissions</label>
                        
                        <div id="editPermissionsGrid" class="edit-permissions-grid-modal">
                            @foreach($allPermissions ?? [] as $permission)
                                <div class="permission-checkbox-item-modal" 
                                     onclick="toggleEditCheckbox(this, 'edit_permission_{{ $permission->id }}')">
                                    <label for="edit_permission_{{ $permission->id }}">
                                        <input type="checkbox"
                                               name="permissions[]"
                                               value="{{ $permission->id }}"
                                               id="edit_permission_{{ $permission->id }}"
                                               onclick="event.stopPropagation();">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer" style="gap: 10px;">
                    <button type="button" onclick="closeEditRoleModal()" class="btn-modal-cancel">Cancel</button>
                    <button type="submit" class="btn-modal-submit-green">Update Role</button>
                </div>
            </form>
        </div>
    </div>

<script>
// Show Role Modal
function showRoleModal(button) {
    const id = button.getAttribute('data-role-id');
    const name = button.getAttribute('data-role-name');
    const created = button.getAttribute('data-role-created');
    const permissionsStr = button.getAttribute('data-role-permissions');
    const permCount = button.getAttribute('data-role-permissions-count');
    
    document.getElementById('modalRoleName').textContent = name;
    document.getElementById('modalRoleIdBadge').textContent = 'Role ID: ' + id;
    document.getElementById('modalRoleNameValue').textContent = name;
    document.getElementById('modalRolePermCount').textContent = permCount;
    document.getElementById('modalRoleCreated').textContent = created;
    document.getElementById('modalRolePermCountLarge').textContent = permCount;
    
    const permissionsGrid = document.getElementById('modalPermissionsGrid');
    const emptyState = document.getElementById('modalEmptyPermissions');
    
    if (permissionsStr && permissionsStr.trim() !== '') {
        const permissions = permissionsStr.split('|||');
        permissionsGrid.innerHTML = '';
        
        permissions.forEach(permission => {
            if (permission.trim()) {
                const chip = document.createElement('div');
                chip.className = 'role-permission-chip-modal';
                chip.innerHTML = `
                    <span class="role-check-icon-modal">✓</span>
                    <span>${permission.trim()}</span>
                `;
                permissionsGrid.appendChild(chip);
            }
        });
        
        permissionsGrid.style.display = 'grid';
        emptyState.style.display = 'none';
    } else {
        permissionsGrid.style.display = 'none';
        emptyState.style.display = 'block';
    }
    
    document.getElementById('roleModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeRoleModal() {
    document.getElementById('roleModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Edit Role Modal
function showEditRoleModal(button) {
    const id = button.getAttribute('data-role-id');
    const name = button.getAttribute('data-role-name');
    const permissionIds = button.getAttribute('data-role-permission-ids');
    
    // Set form action
    document.getElementById('editRoleForm').action = `/roles/update/${id}`;
    
    // Set role name
    document.getElementById('edit_role_name').value = name;
    
    // Uncheck all checkboxes first
    const allCheckboxes = document.querySelectorAll('#editPermissionsGrid input[type="checkbox"]');
    allCheckboxes.forEach(checkbox => {
        checkbox.checked = false;
        checkbox.closest('.permission-checkbox-item-modal').classList.remove('checked');
    });
    
    // Check the permissions that belong to this role
    if (permissionIds && permissionIds.trim() !== '') {
        const ids = permissionIds.split(',');
        ids.forEach(permId => {
            const checkbox = document.getElementById('edit_permission_' + permId.trim());
            if (checkbox) {
                checkbox.checked = true;
                checkbox.closest('.permission-checkbox-item-modal').classList.add('checked');
            }
        });
    }
    
    document.getElementById('editRoleModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeEditRoleModal() {
    document.getElementById('editRoleModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function toggleEditCheckbox(container, checkboxId) {
    const checkbox = document.getElementById(checkboxId);
    checkbox.checked = !checkbox.checked;
    
    if (checkbox.checked) {
        container.classList.add('checked');
    } else {
        container.classList.remove('checked');
    }
}

// Close modals when clicking outside
window.onclick = function(event) {
    const roleModal = document.getElementById('roleModal');
    const editRoleModal = document.getElementById('editRoleModal');
    
    if (event.target === roleModal) {
        closeRoleModal();
    }
    if (event.target === editRoleModal) {
        closeEditRoleModal();
    }
}

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeRoleModal();
        closeEditRoleModal();
    }
});

// Initialize checkbox states on page load
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.permission-checkbox-item-modal input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const container = this.closest('.permission-checkbox-item-modal');
            if (this.checked) {
                container.classList.add('checked');
            } else {
                container.classList.remove('checked');
            }
        });
    });
});

// Delete Role
function deleteRole(id) {
    if (confirm('Are you sure you want to delete this role? This action cannot be undone.')) {
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = '/deleterole/' + id;
        
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