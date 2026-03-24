<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Orchid\Platform\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Администратор (полный доступ)
        Role::updateOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Администратор',
                'permissions' => [
                    'platform.index' => true,
                    'platform.systems.roles' => true,
                    'platform.systems.users' => true,
                    'platform.systems.attachment' => true,
                    // Все остальные права
                ],
            ]
        );

        // Менеджер (только заявки)
        Role::updateOrCreate(
            ['slug' => 'manager'],
            [
                'name' => 'Менеджер',
                'permissions' => [
                    'platform.index' => true,
                    'platform.leads.list' => true,
                    'platform.leads.view' => true,
                    'platform.leads.export' => true,
                ],
            ]
        );
    }
}
