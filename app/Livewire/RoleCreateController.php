<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleCreateController extends Component
{
    public $name = '';
    public $permissions = [];

    public function render()
    {
        return view('livewire.role-create-controller', [
            'allPermissions' => Permission::all()
        ]);
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'required|array|min:1'
        ]);

        try {
            $role = Role::create([
                'name' => $this->name
            ]);

            $role->syncPermissions($this->permissions);

            session()->flash('success', 'Role created successfully!');
            $this->resetForm();

        } catch (\Exception $e) {
            session()->flash('error', 'Error creating role: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset(['name', 'permissions']);
        $this->resetValidation();
    }
}