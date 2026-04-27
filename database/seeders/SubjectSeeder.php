<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicClass;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        $classes = AcademicClass::all();

        if ($classes->isEmpty()) {
            return;
        }

        $subjectsList = ['Mathematics', 'Science', 'English', 'History', 'Geography'];

        foreach ($classes as $class) {
            foreach ($subjectsList as $subjectName) {
                Subject::firstOrCreate(
                    [
                        'name' => $subjectName, 
                        'academic_class_id' => $class->id
                    ],
                    [
                        'code' => strtoupper(substr($subjectName, 0, 3)) . '-' . $class->id,
                        'type' => 'theory'
                    ]
                );
            }
        }
    }
}
