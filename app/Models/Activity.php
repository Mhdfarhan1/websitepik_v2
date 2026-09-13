<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'event_date',
        'time_start',
        'time_end',
        'location',
        'category',
        'image',
        'status',
        'created_by',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($activity) {
            if (empty($activity->slug)) {
                $activity->slug = Str::slug($activity->title) . '-' . Str::random(4);
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
