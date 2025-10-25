<div>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2>Edit Role</h2>
                <p class="mb-0">Update role name and assign permissions.</p>
            </div>
            <div class="card-body">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form wire:submit.prevent="submit">
                    {{-- Role Name Input --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Role Name</label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               wire:model.defer="name"
                               placeholder="e.g., Store Manager">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Permissions Section --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Permissions</label>
                        @error('permissions')
                            <div class="text-danger mb-2">{{ $message }}</div>
                        @enderror
                        
                        <div class="row">
                            @if(isset($allPermissions) && $allPermissions->count() > 0)
                                @php
                                    $groupedPermissions = $allPermissions->groupBy(function($item) {
                                        return explode('.', $item->name)[0];
                                    });
                                @endphp

                                @foreach($groupedPermissions as $groupName => $groupPermissions)
                                    <div class="col-md-6 mb-3">
                                        <div class="card">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0">{{ ucfirst($groupName) }} Management</h6>
                                            </div>
                                            <div class="card-body">
                                                @foreach($groupPermissions as $permission)
                                                    <div class="form-check mb-2">
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
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12">
                                    <div class="alert alert-warning">
                                        No permissions found. Please run seeder or add permissions first.
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Role
                        </button>
                        <button type="button" wire:click="resetForm" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                        <a href="{{ route('role.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>