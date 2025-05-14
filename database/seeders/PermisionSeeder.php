<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'role-show',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-show',
            'status-list',
            'status-create',
            'status-edit',
            'status-delete',
            'status-show',
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            'permission-show',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
