<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'url',
        'icon',
        'is_read',
        'is_sent',
        'sent_at',
        'data',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_sent' => 'boolean',
        'sent_at' => 'datetime',
        'data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeForUser($query, $userId = null)
    {
        if ($userId) {
            return $query->where(function ($q) use ($userId) {
                $q->where('user_id', $userId)->orWhereNull('user_id');
            });
        }
        return $query->whereNull('user_id');
    }

    /**
     * Get label for badge
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'prestasi' => 'Prestasi',
            'jejak_bakti' => 'Jejak Bakti',
            'kegiatan' => 'Kegiatan',
            'artikel' => 'Artikel',
            'pengumuman' => 'Pengumuman',
            'berita' => 'Berita',
            default => 'Informasi',
        };
    }

    /**
     * Get FontAwesome icon class
     */
    public function getTypeIconAttribute(): string
    {
        return match ($this->type) {
            'prestasi' => 'fas fa-trophy text-amber-500',
            'jejak_bakti' => 'fas fa-crown text-yellow-500',
            'kegiatan' => 'fas fa-calendar-alt text-blue-500',
            'artikel' => 'fas fa-newspaper text-emerald-500',
            'pengumuman' => 'fas fa-bullhorn text-rose-500',
            'berita' => 'fas fa-newspaper text-indigo-500',
            default => 'fas fa-bell text-sky-500',
        };
    }

    /**
     * Get badge background & text color classes
     */
    public function getTypeBadgeClassAttribute(): string
    {
        return match ($this->type) {
            'prestasi' => 'bg-amber-100 text-amber-800 border-amber-200',
            'jejak_bakti' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'kegiatan' => 'bg-blue-100 text-blue-800 border-blue-200',
            'artikel' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'pengumuman' => 'bg-rose-100 text-rose-800 border-rose-200',
            'berita' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
            default => 'bg-sky-100 text-sky-800 border-sky-200',
        };
    }
}
