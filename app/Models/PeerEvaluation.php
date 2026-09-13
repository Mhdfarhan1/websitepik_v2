<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeerEvaluation extends Model
{
    use HasFactory;

    protected $table = 'peer_evaluations';

    protected $fillable = [
        'schedule_id',
        'evaluator_id',
        'evaluatee_id',
        'comment',
    ];

    public function schedule()
    {
        return $this->belongsTo(PeerEvaluationSchedule::class, 'schedule_id');
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    public function evaluatee()
    {
        return $this->belongsTo(User::class, 'evaluatee_id');
    }

    public function scores()
    {
        return $this->hasMany(PeerEvaluationScore::class, 'evaluation_id');
    }
}
