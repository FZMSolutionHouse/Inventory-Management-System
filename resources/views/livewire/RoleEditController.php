<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleEditController extends Component
{
    public $roleId;
    public $name;
    public $permissions = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'permissions' => 'required|array|min:1',
    ];

    protected $messages = [
        'name.required' => 'Role name is required.',
        'permissions.required' => 'Please select at least one permission.',
        'permissions.min' => 'Please select at least one permission.',
    ];

    public function mount($roleId)
    {
        $this->roleId = $roleId;
        $role = Role::with('permissions')->findOrFail($roleId);
        
        $this->name = $role->name;
        $this->permissions = $role->permissions->pluck('name')->toArray();
    }

    public function submit()
    {
        $this->validate();

        try {
            $role = Role::findOrFail($this->roleId);
            
            $role->name = $this->name;
            $role->save();
            
            $role->syncPermissions($this->permissions);
            
            session()->flash('success', "Role '{$this->name}' updated successfully!");
            
            return redirect()->route('role.index');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update role: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $role = Role::with('permissions')->findOrFail($this->roleId);
        $this->name = $role->name;
        $this->permissions = $role->permissions->pluck('name')->toArray();
        $this->resetErrorBag();
    }

    public function render()
    {
        $allPermissions = Permission::all();
        
        return view('livewire.role-edit-controller', [
            'allPermissions' => $allPermissions
        ]);
    }
}