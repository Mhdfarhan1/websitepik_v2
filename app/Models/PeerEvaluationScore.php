<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeerEvaluationScore extends Model
{
    use HasFactory;

    protected $table = 'peer_evaluation_scores';

    protected $fillable = [
        'evaluation_id',
        'question_id',
        'score',
    ];

    public function evaluation()
    {
        return $this->belongsTo(PeerEvaluation::class, 'evaluation_id');
    }

    public function question()
    {
        return $this->belongsTo(PeerEvaluationQuestion::class, 'question_id');
    }
}
