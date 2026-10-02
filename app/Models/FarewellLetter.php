<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarewellLetter extends Model
{
    use HasFactory;

    protected $fillable = [
        'generation_title',
        'period',
        'author_representative',
        'cover_photo',
        'excerpt',
        'letter_content',
        'order_index',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_index' => 'integer',
    ];
}
