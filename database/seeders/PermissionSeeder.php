<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
         "userpage",
         "rolepage",
         "productpage",
         "requisitionpage",
         "Dashboardpage",
         "InventoryManagementpage",
         "UserManagamentpage",
         "createuseroption",
         "createroleoption",
         "createproductoption",
         "adminrecordrequisition",
         "editcreateuser",
         "showcreateuser",
         "deletecreateuser",
         "editrole",
         "showrole",
         "deleterole",
         "editproduct",
         "showproduct",
         "deleteproduct",
         "additem",
         "export"
            
        ];
        foreach($permissions as $key => $value){
            Permission::create(['name'=>$value]);
        }
    }
}