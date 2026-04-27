<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'type', 'academic_class_id'];

    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class);
    }
}
