<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = [
            'create post', 'edit post', 'delete post',
            'create category', 'edit category', 'delete category',
            'create tag', 'edit tag', 'delet tag',
            'create comment', 'edit comment', 'delete comment'
        ];
        
        $admin = Role::create(['name' => 'admin']);
        
        foreach ($permissions as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }
        
        $admin->syncPermissions(Permission::all());
        
    }
}
