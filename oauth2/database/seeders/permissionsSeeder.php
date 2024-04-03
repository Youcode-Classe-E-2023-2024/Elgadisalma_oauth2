<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;


class permissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminPermissions = [
            'add_permission',
            'delete_permission',
            'show_permissions',
            'add_role',
            'delete_role',
            'show_roles',
            'add_user',
            'edit_user',
            'delete_user',
        ];

        $userPermissions = [
            'show_permissions',
            'show_roles',
        ];

        foreach ($adminPermissions as $permission) {
            Permission::create([
                'name' => $permission,
                'role_id' => '1',
        ]);
        }

        foreach ($userPermissions as $permission) {
            Permission::create([
                'name' => $permission,
                'role_id' => '2',
        ]);
        }
    }
}
