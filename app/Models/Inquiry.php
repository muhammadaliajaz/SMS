<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    // Allow mass assignment for these fields
    protected $fillable = [
        'name',
        'phone',
        'email',
        'message',
        'status',
        'follow_up_date',
        'inquiry_date', // include this if you have it in DB
    ];

    // Cast date fields to Carbon instances
    protected $casts = [
        'follow_up_date' => 'datetime',
        'inquiry_date'  => 'datetime',
    ];
}
