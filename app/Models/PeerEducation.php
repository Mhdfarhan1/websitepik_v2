<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeerEducation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'desc',
        'desc2',
        'image',
        'order_index',
        'participant_count',
    ];
}
