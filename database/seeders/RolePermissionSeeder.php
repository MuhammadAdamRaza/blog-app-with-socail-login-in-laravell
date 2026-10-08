<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $allPermissions = [
            'users.view' => 'View Users',
            'users.create' => 'Create Users',
            'users.update' => 'Edit Users',
            'users.delete' => 'Delete Users',
            'roles.manage' => 'Manage Roles',
            'roles.assign' => 'Assign Roles',
            'permissions.manage' => 'Manage Permissions',
            'projects.view' => 'View Projects',
            'projects.create' => 'Create Projects',
            'projects.update' => 'Edit Projects',
            'projects.delete' => 'Delete Projects',
            'projects.assign' => 'Assign Projects',
            'projects.status.update' => 'Update Project Status',
            'posts.view' => 'View Posts',
            'posts.create' => 'Create Posts',
            'posts.update' => 'Edit Posts',
            'posts.delete' => 'Delete Posts',
            'posts.assign' => 'Assign Posts',
            'reports.view' => 'View Reports',
            'settings.manage' => 'Manage Settings',
        ];

        $permissionModels = [];

        foreach ($allPermissions as $slug => $name) {
            $permissionModels[$slug] = Permission::updateOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );
        }

        $roles = [
            'super-admin' => [
                'name' => 'Super Admin',
                'permissions' => array_keys($allPermissions),
            ],
            'admin' => [
                'name' => 'Admin',
                'permissions' => [
                    'users.view',
                    'users.create',
                    'users.update',
                    'users.delete',
                    'projects.view',
                    'projects.create',
                    'projects.update',
                    'projects.delete',
                    'reports.view',
                ],
            ],
            'manager' => [
                'name' => 'Manager',
                'permissions' => [
                    'projects.view',
                    'projects.create',
                    'projects.update',
                    'projects.assign',
                    'projects.status.update',
                    'reports.view',
                ],
            ],
            'editor' => [
                'name' => 'Editor',
                'permissions' => [
                    'posts.view',
                    'posts.create',
                    'posts.update',
                ],
            ],
            'user' => [
                'name' => 'User',
                'permissions' => [
                    'projects.view',
                    'posts.view',
                ],
            ],
        ];

        foreach ($roles as $slug => $data) {
            $role = Role::updateOrCreate(
                ['slug' => $slug],
                ['name' => $data['name']]
            );

            $permissionIds = array_map(
                fn(string $permissionSlug) => $permissionModels[$permissionSlug]->id,
                $data['permissions']
            );

            $role->permissions()->sync($permissionIds);
        }
    }
}
