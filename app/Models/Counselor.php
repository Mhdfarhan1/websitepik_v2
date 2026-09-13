<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counselor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role_type',
        'class_or_title',
        'photo',
        'bio_motto',
        'order_index',
    ];
}
