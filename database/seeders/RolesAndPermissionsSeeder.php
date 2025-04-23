<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'search products',
            'interact with chatbot',
            'place orders',
            'make payments',
            'update stock',
            'receive orders',
            'manage product listings',
            'monitor chatbot',
            'oversee transactions',
            'manage users',
            'provide product recommendations',
            'assist in queries',
            'facilitate order placement',
            'view dashboard'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        $farmer = Role::create(['name' => 'farmer']);
        $farmer->givePermissionTo(['search products', 'interact with chatbot', 'place orders', 'make payments']);

        $manufacturer = Role::create(['name' => 'manufacturer']);
        $manufacturer->givePermissionTo(['update stock', 'receive orders', 'manage product listings']);

        $admin = Role::create(['name' => 'administrator']);
        $admin->givePermissionTo(Permission::all());
        $chatbot = Role::create(['name' => 'chatbot']);
        $chatbot->givePermissionTo(['provide product recommendations', 'assist in queries', 'facilitate order placement']);
    }
}
