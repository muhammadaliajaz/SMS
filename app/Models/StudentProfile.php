<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admission_number',
        'roll_number',
        'admission_date',
        'academic_class_id',
        'section_id',
        'father_name',
        'mother_name',
        'dob',
        'gender',
        'blood_group',
        'phone',
        'address',
        'city'
    ];

    // Relationship: Student belongs to AcademicClass
    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class, 'academic_class_id');
    }

    // Optional: If a student belongs to a section
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
