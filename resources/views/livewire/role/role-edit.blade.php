@extends('layouts.adminmaster')
@section('content')
<style>
    /* =================================================================
   EDIT ROLE MODAL STYLES
   ================================================================= */

.modal-content-edit-role {
    max-width: 900px;
    max-height: 90vh;
    overflow-y: auto;
}

/* Form Elements in Edit Modal */
.form-group-modal {
    margin-bottom: 25px;
}

.form-label-modal {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #495057;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-input-modal {
    width: 100%;
    padding: 12px 16px;
    font-size: 15px;
    border: 2px solid #e2e8f0;
    border-radius: 6px;
    transition: all 0.3s ease;
    background: white;
    color: #212529;
    box-sizing: border-box;
}

.form-input-modal:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

/* Permissions Section in Edit Modal */
.permissions-section-edit {
    margin-top: 25px;
}

.edit-permissions-grid-modal {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 12px;
    margin-top: 15px;
    max-height: 400px;
    overflow-y: auto;
    padding: 5px;
}

.permission-checkbox-item-modal {
    background: #f8f9fa;
    padding: 12px 15px;
    border-radius: 6px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    cursor: pointer;
}

.permission-checkbox-item-modal:hover {
    border-color: #10b981;
    background: #f0fdf4;
}

.permission-checkbox-item-modal.checked {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    border-color: #10b981;
}

.permission-checkbox-item-modal input[type="checkbox"] {
    width: 16px;
    height: 16px;
    margin-right: 10px;
    cursor: pointer;
    accent-color: #10b981;
}

.permission-checkbox-item-modal label {
    cursor: pointer;
    font-size: 13px;
    font-weight: 500;
    color: #495057;
    display: flex;
    align-items: center;
    margin: 0;
}

.permission-checkbox-item-modal.checked label {
    color: #065f46;
    font-weight: 600;
}

/* Modal Footer Buttons */
.btn-modal-submit-green {
    background-color: #10b981;
    color: white;
    padding: 10px 25px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    transition: background-color 0.2s;
}

.btn-modal-submit-green:hover {
    background-color: #059669;
}

/* Mobile Responsive for Edit Role Modal */
@media screen and (max-width: 768px) {
    .modal-content-edit-role {
        width: 95%;
        max-height: 95vh;
    }
    
    .edit-permissions-grid-modal {
        grid-template-columns: 1fr;
        max-height: 300px;
    }
}
    .edit-role-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .edit-role-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
    }

    .edit-role-header h1 {
        font-size: 32px;
        margin: 0 0 10px 0;
        font-weight: 700;
    }

    .edit-role-header p {
        font-size: 16px;
        margin: 0;
        opacity: 0.9;
    }

    .edit-role-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .dark-theme .edit-role-card {
        background: #242526;
    }

    .edit-role-card-body {
        padding: 35px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .dark-theme .form-label {
        color: #E0E0E0;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        font-size: 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        transition: all 0.3s ease;
        background: white;
        color: #333;
    }

    .dark-theme .form-input {
        background: #1E1E1E;
        border-color: #4a5568;
        color: #E0E0E0;
    }

    .form-input:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    .form-input.is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
        display: block;
    }

    .permissions-section {
        margin-top: 30px;
    }

    .permissions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }

    .permission-checkbox-item {
        background: #f9fafb;
        padding: 15px;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .dark-theme .permission-checkbox-item {
        background: #2A2A2A;
        border-color: #4a5568;
    }

    .permission-checkbox-item:hover {
        border-color: #10b981;
        background: #f0fdf4;
    }

    .dark-theme .permission-checkbox-item:hover {
        background: rgba(16, 185, 129, 0.1);
    }

    .permission-checkbox-item.checked {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border-color: #10b981;
    }

    .dark-theme .permission-checkbox-item.checked {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(16, 185, 129, 0.3) 100%);
        border-color: #10b981;
    }

    .permission-checkbox-item input[type="checkbox"] {
        width: 18px;
        height: 18px;
        margin-right: 10px;
        cursor: pointer;
        accent-color: #10b981;
    }

    .permission-checkbox-item label {
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        color: #333;
        display: flex;
        align-items: center;
        margin: 0;
    }

    .dark-theme .permission-checkbox-item label {
        color: #E0E0E0;
    }

    .permission-checkbox-item.checked label {
        color: #065f46;
        font-weight: 600;
    }

    .dark-theme .permission-checkbox-item.checked label {
        color: #6ee7b7;
    }

    .alert-warning {
        background: #fff3cd;
        border: 1px solid #ffc107;
        color: #856404;
        padding: 15px;
        border-radius: 8px;
        margin-top: 15px;
    }

    .edit-role-actions {
        padding: 25px 35px;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
        display: flex;
        gap: 15px;
        justify-content: flex-end;
    }

    .dark-theme .edit-role-actions {
        background: #2A2A2A;
        border-top-color: #4a5568;
    }

    .btn-action {
        padding: 12px 30px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background-color: #10b981;
        color: white;
    }

    .btn-primary:hover {
        background-color: #059669;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
    }

    .btn-secondary {
        background-color: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #4b5563;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(107, 114, 128, 0.4);
    }

    .btn-back {
        background-color: #f3f4f6;
        color: #333;
        border: 2px solid #e5e7eb;
    }

    .dark-theme .btn-back {
        background-color: #2A2A2A;
        color: #E0E0E0;
        border-color: #4a5568;
    }

    .btn-back:hover {
        background-color: #e5e7eb;
        transform: translateY(-2px);
    }

    .dark-theme .btn-back:hover {
        background-color: #4a5568;
    }

    @media (max-width: 768px) {
        .edit-role-container {
            padding: 15px;
        }

        .edit-role-header {
            padding: 20px;
        }

        .edit-role-header h1 {
            font-size: 24px;
        }

        .edit-role-card-body {
            padding: 20px;
        }

        .permissions-grid {
            grid-template-columns: 1fr;
        }

        .edit-role-actions {
            flex-direction: column;
            padding: 20px;
        }

        .btn-action {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="edit-role-container">
    <!-- Header -->
    <div class="edit-role-header">
        <h1>Edit Role</h1>
        <p>Update role name and permissions</p>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Edit Form -->
    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="edit-role-card">
            <div class="edit-role-card-body">
                
                {{-- Role Name Input --}}
                <div class="form-group">
                    <label class="form-label" for="name">Role Name</label>
                    <input type="text" 
                           class="form-input @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $role->name) }}"
                           placeholder="Enter role name"
                           required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Permissions Checkboxes --}}
                <div class="permissions-section">
                    <label class="form-label">Select Permissions</label>
                    
                    @if($permissions->count() > 0)
                        <div class="permissions-grid">
                            @foreach($permissions as $permission)
                                <div class="permission-checkbox-item {{ in_array($permission->id, $rolePermissions ?? []) ? 'checked' : '' }}" 
                                     onclick="toggleCheckbox(this, 'permission_{{ $permission->id }}')">
                                    <label for="permission_{{ $permission->id }}">
                                        <input type="checkbox"
                                               name="permissions[]"
                                               value="{{ $permission->id }}"
                                               id="permission_{{ $permission->id }}"
                                               {{ in_array($permission->id, $rolePermissions ?? []) ? 'checked' : '' }}
                                               onclick="event.stopPropagation();">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert-warning">
                            No permissions available.
                        </div>
                    @endif

                    @error('permissions')
                        <span class="invalid-feedback" style="display: block; margin-top: 10px;">{{ $message }}</span>
                    @enderror
                </div>

            </div>
            
            <div class="edit-role-actions">
                <a href="/roles" class="btn-action btn-back">← Back to Roles</a>
                <button type="submit" class="btn-action btn-primary">Update Role</button>
            </div>
        </div>
    </form>
</div>

<script>
function toggleCheckbox(container, checkboxId) {
    const checkbox = document.getElementById(checkboxId);
    checkbox.checked = !checkbox.checked;
    
    // Toggle the checked class
    if (checkbox.checked) {
        container.classList.add('checked');
    } else {
        container.classList.remove('checked');
    }
}

// Initialize checked states on page load
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.permission-checkbox-item input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const container = this.closest('.permission-checkbox-item');
            if (this.checked) {
                container.classList.add('checked');
            } else {
                container.classList.remove('checked');
            }
        });
    });
});
</script>
@endsection