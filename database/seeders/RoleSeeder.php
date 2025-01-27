<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supperadmin = Role::create(['name' => 'Supper admin', 'guard_name' => 'web']);
        $admin = Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        $teacher = Role::create(['name' => 'Teacher', 'guard_name' => 'web']);
        $user = Role::create(['name' => 'User', 'guard_name' => 'web']);
//        DB::table('roles')->truncate();
    }
}
