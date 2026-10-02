<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemoryMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_name',
        'sender_role',
        'recipient_name',
        'generation',
        'category',
        'message',
        'paper_theme',
        'hug_count',
        'is_pinned',
        'is_approved',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_approved' => 'boolean',
        'hug_count' => 'integer',
    ];

    /**
     * Category human readable badge and label.
     */
    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'terima_kasih' => 'Terima Kasih Mendalam',
            'maaf' => 'Permohonan Maaf',
            'rindu' => 'Rindu & Kenangan',
            'pesan_adik' => 'Pesan untuk Adik Kelas',
            'catatan_pembina' => 'Catatan Pembina',
            default => 'Ungkapan Rasa',
        };
    }

    public function getCategoryColorAttribute(): string
    {
        return match ($this->category) {
            'terima_kasih' => 'amber',
            'maaf' => 'rose',
            'rindu' => 'sky',
            'pesan_adik' => 'emerald',
            'catatan_pembina' => 'purple',
            default => 'slate',
        };
    }
}
