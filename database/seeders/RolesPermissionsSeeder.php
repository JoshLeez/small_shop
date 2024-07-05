<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles_permissions = [
            'developer' =>[
                'role-list',
                'role-create',
                'role-edit',
                'role-delete',
                'product-list',
                'product-create',
                'product-edit',
                'product-delete'
            ],
            'admin'=>[
                'role-list',
                'product-list',
                'product-create',
                'product-edit',
                'product-delete'
            ],
            'guest'=>[
                'role-list',
                'product-list',
            ]
        ];

        foreach ($roles_permissions as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            foreach ($permissions as $permissionName) {
                Permission::firstOrCreate(['name' => $permissionName]);
            }

            // Sync permissions to role
            $role->syncPermissions(Permission::whereIn('name', $permissions)->get());
        }
    }
}
