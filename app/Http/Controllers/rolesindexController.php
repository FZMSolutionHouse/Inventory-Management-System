<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RolesIndexController extends Controller
{
    public function rolebase(){
        $roles = Role::with("permissions")->get();
        return view('roles',compact("roles"));
    }

    public function show($id){
        $role = Role::with("permissions")->findOrFail($id);
        return view('showrole', compact("role"));
    }

    public function edit($id){
        $role = Role::with("permissions")->findOrFail($id);
        return view('livewire.wrapper.edit-role', compact("role"));
    }

    public function delete($id){
        try {
            $role = Role::findOrFail($id);
            $roleName = $role->name;
            $role->delete();
            
            return redirect('/roles')->with('success', "Role '{$roleName}' deleted successfully!");
            
        } catch (\Exception $e) {
            return redirect('/roles')->with('error', 'Failed to delete role: ' . $e->getMessage());
        }
    }
}