<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counseling extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'topic',
        'student_class',
        'counselor_name',
        'date',
        'description',
        'status',
    ];
}
