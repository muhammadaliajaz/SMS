<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicClass;
use App\Models\Section;

class ClassesSeeder extends Seeder
{
    public function run()
    {
        $classes = [
            'Grade 1' => ['A', 'B'],
            'Grade 2' => ['A', 'B'],
            'Grade 3' => ['A', 'B'],
        ];

        foreach ($classes as $className => $sections) {
            $class = AcademicClass::firstOrCreate(['name' => $className]);
            
            foreach ($sections as $sectionName) {
                Section::firstOrCreate([
                    'name' => $sectionName,
                    'academic_class_id' => $class->id
                ]);
            }
        }
    }
}
