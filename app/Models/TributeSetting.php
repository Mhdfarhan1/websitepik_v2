<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TributeSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_title',
        'title',
        'subtitle',
        'appreciation_quote',
        'poster_image',
        'appreciation_count',
        'show_on_homepage',
    ];

    protected $casts = [
        'show_on_homepage' => 'boolean',
        'appreciation_count' => 'integer',
    ];
}
