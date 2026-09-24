<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TributeMemory extends Model
{
    use HasFactory;

    protected $fillable = [
        'tribute_edition_id',
        'title',
        'image',
        'caption',
        'event_date',
        'order_index',
    ];

    protected $casts = [
        'event_date' => 'date',
        'order_index' => 'integer',
        'tribute_edition_id' => 'integer',
    ];

    public function edition(): BelongsTo
    {
        return $this->belongsTo(TributeEdition::class, 'tribute_edition_id');
    }
}
