<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TimeCapsule extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'creator_generation',
        'created_date',
        'unlock_date',
        'seal_message',
        'cover_image',
        'theme_color',
        'is_featured',
        'is_active',
        'order_index',
    ];

    protected $casts = [
        'created_date' => 'date',
        'unlock_date' => 'datetime',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'order_index' => 'integer',
    ];

    /**
     * All items inside this capsule
     */
    public function items(): HasMany
    {
        return $this->hasMany(TimeCapsuleItem::class, 'time_capsule_id')
            ->orderBy('order_index', 'asc')
            ->orderBy('id', 'asc');
    }

    /**
     * Letters / Messages to the future
     */
    public function letters(): HasMany
    {
        return $this->hasMany(TimeCapsuleItem::class, 'time_capsule_id')
            ->where('type', 'letter')
            ->where('is_active', true)
            ->orderBy('order_index', 'asc')
            ->orderBy('id', 'asc');
    }

    /**
     * Stories / Chronicles
     */
    public function stories(): HasMany
    {
        return $this->hasMany(TimeCapsuleItem::class, 'time_capsule_id')
            ->where('type', 'story')
            ->where('is_active', true)
            ->orderBy('order_index', 'asc')
            ->orderBy('id', 'asc');
    }

    /**
     * Photos
     */
    public function photos(): HasMany
    {
        return $this->hasMany(TimeCapsuleItem::class, 'time_capsule_id')
            ->where('type', 'photo')
            ->where('is_active', true)
            ->orderBy('order_index', 'asc')
            ->orderBy('id', 'asc');
    }

    /**
     * Videos
     */
    public function videos(): HasMany
    {
        return $this->hasMany(TimeCapsuleItem::class, 'time_capsule_id')
            ->where('type', 'video')
            ->where('is_active', true)
            ->orderBy('order_index', 'asc')
            ->orderBy('id', 'asc');
    }

    /**
     * Check if the capsule is currently locked based on date.
     */
    public function isLocked(): bool
    {
        if (!$this->unlock_date) {
            return false;
        }
        return Carbon::now()->lt($this->unlock_date);
    }

    /**
     * Attribute: is_locked
     */
    public function getIsLockedAttribute(): bool
    {
        return $this->isLocked();
    }

    /**
     * Formatted Indonesian created date
     */
    public function getFormattedCreatedDateAttribute(): string
    {
        if (!$this->created_date) return '-';
        return Carbon::parse($this->created_date)->locale('id')->isoFormat('D MMMM Y');
    }

    /**
     * Formatted Indonesian unlock date
     */
    public function getFormattedUnlockDateAttribute(): string
    {
        if (!$this->unlock_date) return '-';
        return Carbon::parse($this->unlock_date)->locale('id')->isoFormat('D MMMM Y');
    }

    /**
     * Formatted Indonesian unlock datetime with hour
     */
    public function getFormattedUnlockDateTimeAttribute(): string
    {
        if (!$this->unlock_date) return '-';
        return Carbon::parse($this->unlock_date)->locale('id')->isoFormat('D MMMM Y, HH:mm') . ' WIB';
    }

    /**
     * Milliseconds timestamp for countdown js
     */
    public function getUnlockTimestampMsAttribute(): int
    {
        return $this->unlock_date ? $this->unlock_date->timestamp * 1000 : 0;
    }

    /**
     * Status Text
     */
    public function getStatusTextAttribute(): string
    {
        return $this->is_locked ? 'TERKUNCI' : 'TELAH DIBUKA';
    }

    /**
     * Status icon + label for UI
     */
    public function getStatusBadgeAttribute(): array
    {
        if ($this->is_locked) {
            return [
                'text' => 'TERKUNCI',
                'icon' => 'fas fa-lock',
                'color' => 'amber',
                'bg_class' => 'bg-amber-500/15 text-amber-400 border border-amber-500/30',
                'dot_class' => 'bg-amber-400',
            ];
        }

        return [
            'text' => 'TELAH DIBUKA',
            'icon' => 'fas fa-lock-open',
            'color' => 'emerald',
            'bg_class' => 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30',
            'dot_class' => 'bg-emerald-400',
        ];
    }
}
