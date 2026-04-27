<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'academic_class_id',
        'subject_id',
        'date_of_exam',
        'start_time',
        'end_time',
        'room_no',
        'full_marks',
        'passing_marks',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
