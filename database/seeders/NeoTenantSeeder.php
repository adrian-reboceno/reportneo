<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class NeoTenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = [
            'neotenant-list',
            'neotenant-create',
            'neotenant-edit',
            'neotenant-delete',
            'neotenant-show',
            'neoapi-list',
            'neoapi-create',
            'neoapi-edit',
            'neoapi-delete',
            'neoapi-show',
            'neoorganization-list',
            'neoorganization-create',
            'neoorganization-edit',
            'neoorganization-delete',
            'neoorganization-show',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
