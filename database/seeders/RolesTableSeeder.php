<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        // Use DB::table safety
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $roles = [
            ['name' => 'admin', 'display_name' => 'System Administrator', 'description' => 'Full access to system'],
            ['name' => 'teacher', 'display_name' => 'Teacher', 'description' => 'Manage classes and students'],
            ['name' => 'student', 'display_name' => 'Student', 'description' => 'Access to learning resources'],
            ['name' => 'parent', 'display_name' => 'Parent', 'description' => 'View child progress'],
            ['name' => 'accountant', 'display_name' => 'Accountant', 'description' => 'Manage fees and accounts'],
            ['name' => 'staff', 'display_name' => 'Staff', 'description' => 'General Staff Member'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
