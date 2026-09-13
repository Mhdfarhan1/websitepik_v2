<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeerEvaluationSchedule extends Model
{
    use HasFactory;

    protected $table = 'peer_evaluation_schedules';

    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function evaluations()
    {
        return $this->hasMany(PeerEvaluation::class, 'schedule_id');
    }
}
