<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TributeEdition extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_title',
        'title',
        'period',
        'subtitle',
        'appreciation_quote',
        'story_title',
        'story_content',
        'poster_image',
        'school_logo',
        'audio_file',
        'audio_title',
        'audio_artist',
        'institution_name',
        'institution_subtext',
        'appreciation_count',
        'is_featured',
        'is_active',
        'order_index',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'appreciation_count' => 'integer',
        'order_index' => 'integer',
    ];

    /**
     * Figures in this edition
     */
    public function figures(): HasMany
    {
        return $this->hasMany(TributeFigure::class, 'tribute_edition_id')->orderBy('order_index', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Memories in this edition
     */
    public function memories(): HasMany
    {
        return $this->hasMany(TributeMemory::class, 'tribute_edition_id')->orderBy('order_index', 'asc')->orderBy('id', 'desc');
    }
}
