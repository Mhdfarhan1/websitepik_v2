<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaderHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'period',
        'generation',
        'title_badge',
        'status',
        'photo',
        'quote',
        'story',
        'experience',
        'hope',
        'instagram',
        'linkedin',
        'order_index',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_index' => 'integer',
    ];
}
