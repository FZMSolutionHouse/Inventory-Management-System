<div> {{-- This is now the single root element wrapping everything --}}

    <div class="create-role-container">
        <div class="form-card">
            <div class="card-header">
                <h2>Create New Role</h2>
                <p>Define a new role and assign permissions.</p>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="submit">
                    {{-- Role Name Input --}}
                    <div class="form-group">
                        <label for="name" class="form-label">Role Name</label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               wire:model.lazy="name"
                               placeholder="e.g., Store Manager">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Permissions Section --}}
                    <div class="form-group">
                        <label class="form-label">Select Permissions</label>
                        @error('permissions')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        
                        <div class="permissions-grid">
                            @php
                                $groupedPermissions = $allPermissions->groupBy(function($item, $key) {
                                    return explode('.', $item->name)[0];

                                });
                            @endphp

                            @forelse($groupedPermissions as $groupName => $permissions)
                                <div class="permission-group">
                                    <h6 class="group-title">{{ ucfirst($groupName) }} Management</h6>
                                    @foreach($permissions as $permission)
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   value="{{ $permission->name }}" 
                                                   wire:model="permissions"
                                                   id="permission_{{ $permission->id }}">
                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                {{ ucfirst(str_replace(['.', '-'], ' ', $permission->name)) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @empty
                                <div class="alert-warning">
                                    No permissions found. Please run seeder or add permissions first.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            Create Role
                        </button>
                        <button type="button" wire:click="resetForm" class="btn btn-secondary">
                            Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- CORRECTED: The script is now INSIDE the main div --}}
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('roleCreated', (data) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                });
            });

            Livewire.on('roleCreationError', (data) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.message || 'Something went wrong!',
                });
            });
        });
    </script>
    
</div> {{-- End of the single root element --}}