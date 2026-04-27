<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            SettingsSeeder::class,
            RolesTableSeeder::class,
            ClassesSeeder::class,
            SubjectSeeder::class,
            FeeTypeSeeder::class,
            UsersTableSeeder::class,
        ]);
    }
}
