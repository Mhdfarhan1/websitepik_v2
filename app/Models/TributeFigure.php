<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TributeFigure extends Model
{
    use HasFactory;

    protected $fillable = [
        'tribute_edition_id',
        'name',
        'honor_title',
        'period',
        'badge_color',
        'photo',
        'quote',
        'contribution',
        'instagram',
        'order_index',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_index' => 'integer',
        'tribute_edition_id' => 'integer',
    ];

    public function edition(): BelongsTo
    {
        return $this->belongsTo(TributeEdition::class, 'tribute_edition_id');
    }
}
