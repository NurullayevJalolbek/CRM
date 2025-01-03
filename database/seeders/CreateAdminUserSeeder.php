<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an admin user
        $user = User::create([
            'name' => 'murod qodirov', 
            'email' => 'murodqodirov22@gmail.com',
            'password' => bcrypt('12345678')
        ]);
      
        // Create an Admin role
        $role = Role::create(['name' => 'Admin']);
        
        // Assign role to user
        $user->assignRole($role->name);
    }
}