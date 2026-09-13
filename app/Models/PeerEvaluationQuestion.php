<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeerEvaluationQuestion extends Model
{
    use HasFactory;

    protected $table = 'peer_evaluation_questions';

    protected $fillable = [
        'question_text',
    ];

    public function scores()
    {
        return $this->hasMany(PeerEvaluationScore::class, 'question_id');
    }
}
