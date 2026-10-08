<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        $superAdminEmail = env('SUPER_ADMIN_EMAIL');
        $superAdminPassword = env('SUPER_ADMIN_PASSWORD');

        if ($superAdminEmail && $superAdminPassword) {
            $superAdmin = User::updateOrCreate(
                ['email' => strtolower(trim($superAdminEmail))],
                [
                    'name' => env('SUPER_ADMIN_NAME', 'Super Admin'),
                    'password' => $superAdminPassword,
                ]
            );

            $superAdminRole = Role::where('slug', 'super-admin')->firstOrFail();
            $superAdmin->roles()->sync([$superAdminRole->id]);
        }
    }
}
