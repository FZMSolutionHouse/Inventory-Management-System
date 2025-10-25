<?php

namespace App\Livewire\Role;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleEdit extends Component
{

    public $role;
    public $name;
    public $allpermissions = [];
    public $permissions = [];

    public function mount($id)
    {
        // Find the role by its ID, or fail
        $this->role = Role::findOrFail($id);

        // Get all available permissions
        $this->allpermissions = Permission::all();

        // Pre-fill the form fields with the existing role data
        $this->name = $this->role->name;
        
        // Pre-select the permissions associated with this role
        // The pluck('id')->toArray() is often more reliable with Livewire's select/checkbox binding
        $this->permissions = $this->role->permissions()->pluck('id')->toArray();
    }
public function render()
{
    return view('livewire.role.role-edit'); // Just return the component's view
}

    public function submit()
    {
        // 1. Corrected Validation: Ignore the current role's ID when checking for uniqueness
        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $this->role->id,
            'permissions' => 'required|array|min:1'
        ]);
        
        // Update the role's name
        $this->role->name = $this->name;
        $this->role->save();
        
        // 2. Corrected Method Name: syncPermissions (plural)
        $this->role->syncPermissions($this->permissions);
        
        // (Optional but Recommended) Add a success message and redirect
        session()->flash('success', 'Role updated successfully.');
        return redirect()->to('/roles'); // or wherever your roles index page is
    }
}