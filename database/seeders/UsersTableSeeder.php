<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\StudentProfile;
use App\Models\StaffProfile;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $studentRole = Role::where('name', 'student')->first();
        $staffRole = Role::where('name', 'staff')->first();
        $adminRole = Role::where('name', 'admin')->first();

        // Ensure Admin Exists
        if ($adminRole) {
            User::firstOrCreate(
                ['email' => 'admin@school.com'],
                [
                    'name' => 'Super Admin',
                    'password' => Hash::make('password'),
                    'role_id' => $adminRole->id
                ]
            );
        }

        // Create Students
        if ($studentRole) {
            for ($i = 0; $i < 10; $i++) {
                $user = User::create([
                    'name' => $faker->name,
                    'email' => $faker->unique()->email,
                    'password' => Hash::make('password'),
                    'role_id' => $studentRole->id,
                ]);
                StudentProfile::create([
                    'user_id' => $user->id,
                    'admission_number' => 'ADM' . $faker->unique()->numberBetween(100000, 999999),
                    'phone' => $faker->phoneNumber,
                ]);
            }
        }
        
        // Create Staff
        if ($staffRole) {
            for ($i = 0; $i < 5; $i++) {
                $user = User::create([
                    'name' => $faker->name,
                    'email' => $faker->unique()->email,
                    'password' => Hash::make('password'),
                    'role_id' => $staffRole->id,
                ]);
                StaffProfile::create([
                    'user_id' => $user->id,
                    'employee_code' => 'EMP' . $faker->unique()->numberBetween(100000, 999999),
                    'designation' => 'Staff',
                ]);
            }
        }
    }
}
