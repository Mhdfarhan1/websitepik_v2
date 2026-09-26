<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaderSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_title',
        'page_title',
        'subtitle',
        'audio_file',
        'audio_title',
        'audio_artist',
        'is_audio_active',
        'banner_image',
    ];

    protected $casts = [
        'is_audio_active' => 'boolean',
    ];
}
