<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_code',
        'designation',
        'department',
        'qualification',
        'joining_date',
        'basic_salary',
        'phone',
        'address',
        'gender',
    ];
}
