<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimeCapsuleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'time_capsule_id',
        'type',
        'title',
        'author_name',
        'author_role',
        'content',
        'media_path',
        'external_url',
        'order_index',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_index' => 'integer',
    ];

    /**
     * Parent time capsule
     */
    public function timeCapsule(): BelongsTo
    {
        return $this->belongsTo(TimeCapsule::class, 'time_capsule_id');
    }
}
