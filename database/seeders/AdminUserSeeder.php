<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Orchid\Platform\Models\Role;
use Orchid\Support\Facades\Dashboard;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@narrative.com'],
            [
                'name' => 'Администратор',
                'password' => Hash::make('1810'),
                'permissions' => Dashboard::getAllowAllPermission(),
            ]
        );
        $manager = User::updateOrCreate(
            ['email' => 'manager@narrative.com'],
            [
                'name' => 'Менеджер',
                'password' => Hash::make('1810'),
                'permissions' => Dashboard::getAllowAllPermission(),
            ]
        );

        $adminRole = Role::where('slug', 'admin')->first();
        $managerRole = Role::where('slug', 'manager')->first();
        $admin->roles()->syncWithoutDetaching($adminRole);
        $manager->roles()->syncWithoutDetaching($managerRole);
    }
}
