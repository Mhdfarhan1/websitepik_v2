<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $table = 'achievements';

    protected $fillable = [
        'title',
        'description',
        'image',
        'author',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function images()
    {
        return $this->hasMany(AchievementImage::class, 'achievement_id')->orderBy('order_index')->orderBy('id');
    }
}
