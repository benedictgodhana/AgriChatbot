<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create an admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('administrator');

        // Create a farmer user
        $farmer = User::create([
            'name' => 'John Farmer',
            'email' => 'farmer@example.com',
            'password' => bcrypt('password'),
        ]);
        $farmer->assignRole('farmer');

        // Create a manufacturer user
        $manufacturer = User::create([
            'name' => 'Mike Manufacturer',
            'email' => 'manufacturer@example.com',
            'password' => bcrypt('password'),
        ]);
        $manufacturer->assignRole('manufacturer');
    }
}
