<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'academic_class_id', 'capacity'];

    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class);
    }
}
