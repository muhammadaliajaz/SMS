<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FeeType;

class FeeTypeSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Tuition Fee',
                'description' => 'Monthly academic tuition fees.'
            ],
            [
                'name' => 'Admission Fee',
                'description' => 'One-time fee for new enrollments.'
            ],
            [
                'name' => 'Transport Fee',
                'description' => 'Monthly charge for school bus service.'
            ],
            [
                'name' => 'Exam Fee',
                'description' => 'Fee collected before semester examinations.'
            ],
            [
                'name' => 'Lab Fee',
                'description' => 'For science and computer laboratory maintenance.'
            ],
            [
                'name' => 'Library Fine',
                'description' => 'Late return or damage of books.'
            ]
        ];
    
        foreach ($categories as $cat) {
            FeeType::firstOrCreate(
                ['name' => $cat['name']],
                ['description' => $cat['description']]
            );
        }
    }
}
