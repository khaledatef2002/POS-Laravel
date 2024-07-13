<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owner = Role::create([
            'name' => 'owner',
            'display_name' => 'Project Owner', // optional
            'description' => 'User is the owner of a given project', // optional
        ]);
        
        $createtUser = Permission::create([
            'name' => 'create-user',
        ]);
        $readUser = Permission::create([
            'name' => 'read-user',
        ]);
        $editUser = Permission::create([
            'name' => 'edit-user',
        ]);
        $removeUser = Permission::create([
            'name' => 'remove-user',
        ]);
        
        $createtRole = Permission::create([
            'name' => 'create-role',
        ]);
        $readRole = Permission::create([
            'name' => 'read-role',
        ]);
        $editRole = Permission::create([
            'name' => 'edit-role',
        ]);
        $removeRole = Permission::create([
            'name' => 'remove-role',
        ]);
        
        $createtCategory = Permission::create([
            'name' => 'create-category',
        ]);
        $readCategory = Permission::create([
            'name' => 'read-category',
        ]);
        $editCategory = Permission::create([
            'name' => 'edit-category',
        ]);
        $removeCategory = Permission::create([
            'name' => 'remove-category',
        ]);
        
        $createtProduct = Permission::create([
            'name' => 'create-product',
        ]);
        $readProduct = Permission::create([
            'name' => 'read-product',
        ]);
        $editProduct = Permission::create([
            'name' => 'edit-product',
        ]);
        $removeProduct = Permission::create([
            'name' => 'remove-product',
        ]);
        
        $createtClient = Permission::create([
            'name' => 'create-client',
        ]);
        $readClient = Permission::create([
            'name' => 'read-client',
        ]);
        $editClient = Permission::create([
            'name' => 'edit-client',
        ]);
        $removeClient = Permission::create([
            'name' => 'remove-client',
        ]);


        $createOrder = Permission::create([
            'name' => 'create-order',
        ]);

        $readOrder = Permission::create([
            'name' => 'read-order',
        ]);

        $editOrder = Permission::create([
            'name' => 'edit-order',
        ]);

        $removeOrder = Permission::create([
            'name' => 'remove-order',
        ]);

        $owner->givePermissions([$createtUser, $readUser, $editUser, $removeUser, $createtRole, $readRole, $editRole, $removeRole, $createtCategory, $readCategory, $editCategory, $removeCategory, $createtProduct, $readProduct, $editProduct, $removeProduct, $createtClient, $readClient, $editClient, $removeClient, $createOrder, $readOrder, $editOrder, $removeOrder]);
    }
}
