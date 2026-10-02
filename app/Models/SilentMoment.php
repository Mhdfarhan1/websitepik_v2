<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SilentMoment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'period',
        'photo',
        'narrative',
        'order_index',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_index' => 'integer',
    ];
}
