<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        DB::table('settings')->updateOrInsert(
            ['key' => 'school_name'],
            ['value' => 'My Great School', 'group' => 'general']
        );
        
        // Add other default settings if needed
    }
}
