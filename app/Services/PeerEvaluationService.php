<?php

namespace App\Services;

use App\Models\PeerEvaluationSchedule;
use App\Models\PeerEvaluationQuestion;
use App\Models\PeerEvaluation;
use App\Models\PeerEvaluationScore;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PeerEvaluationService
{
    /**
     * Get active evaluation schedule.
     */
    public function getActiveSchedule()
    {
        return PeerEvaluationSchedule::where('is_active', true)->first();
    }

    /**
     * Get all schedules.
     */
    public function getAllSchedules()
    {
        return PeerEvaluationSchedule::orderBy('created_at', 'desc')->get();
    }

    /**
     * Get all evaluation questions.
     */
    public function getQuestions()
    {
        return PeerEvaluationQuestion::all();
    }

    /**
     * Get users available to be evaluated (excluding current user).
     */
    public function getEvaluatees(int $evaluatorId)
    {
        return User::where('role', '!=', 'super_admin')
            ->where('id', '!=', $evaluatorId)
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * Submit peer evaluation.
     */
    public function submitEvaluation(int $evaluatorId, int $evaluateeId, int $scheduleId, array $scores, ?string $comment)
    {
        return DB::transaction(function () use ($evaluatorId, $evaluateeId, $scheduleId, $scores, $comment) {
            // Check if already evaluated in this schedule
            $exists = PeerEvaluation::where('schedule_id', $scheduleId)
                ->where('evaluator_id', $evaluatorId)
                ->where('evaluatee_id', $evaluateeId)
                ->exists();

            if ($exists) {
                throw new \Exception("Anda sudah memberikan penilaian untuk rekan ini dalam jadwal ini.");
            }

            // Create evaluation session
            $evaluation = PeerEvaluation::create([
                'schedule_id' => $scheduleId,
                'evaluator_id' => $evaluatorId,
                'evaluatee_id' => $evaluateeId,
                'comment' => $comment,
            ]);

            // Save score for each question
            foreach ($scores as $questionId => $scoreValue) {
                PeerEvaluationScore::create([
                    'evaluation_id' => $evaluation->id,
                    'question_id' => $questionId,
                    'score' => $scoreValue, // 1 to 4 scale
                ]);
            }

            return $evaluation;
        });
    }

    /**
     * Get evaluations received by a user.
     */
    public function getEvaluationsReceivedByUser(int $userId, ?int $scheduleId = null)
    {
        $query = PeerEvaluation::where('evaluatee_id', $userId)
            ->with(['evaluator', 'scores.question', 'schedule']);

        if ($scheduleId) {
            $query->where('schedule_id', $scheduleId);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get evaluations submitted by a user.
     */
    public function getEvaluationsSubmittedByUser(int $userId, ?int $scheduleId = null)
    {
        $query = PeerEvaluation::where('evaluator_id', $userId)
            ->with(['evaluatee', 'schedule']);

        if ($scheduleId) {
            $query->where('schedule_id', $scheduleId);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get list of peer user IDs evaluated by evaluator in a specific schedule.
     */
    public function getEvaluatedPeerIds(int $evaluatorId, int $scheduleId): array
    {
        return PeerEvaluation::where('schedule_id', $scheduleId)
            ->where('evaluator_id', $evaluatorId)
            ->pluck('evaluatee_id')
            ->toArray();
    }

    /**
     * Get aggregate evaluation summary of all members for Admin.
     */
    public function getMembersEvaluationSummary(?int $scheduleId = null)
    {
        $members = User::where('role', '!=', 'super_admin')
            ->orderBy('name', 'asc')
            ->get();

        $summary = [];

        foreach ($members as $member) {
            $evaluationsQuery = PeerEvaluation::where('evaluatee_id', $member->id);
            if ($scheduleId) {
                $evaluationsQuery->where('schedule_id', $scheduleId);
            }
            $evaluations = $evaluationsQuery->get();

            $totalEvaluations = $evaluations->count();
            $averageScore = 0;

            if ($totalEvaluations > 0) {
                // Get all scores received by this member
                $evaluationIds = $evaluations->pluck('id')->toArray();
                $avg = PeerEvaluationScore::whereIn('evaluation_id', $evaluationIds)->avg('score');
                $averageScore = round($avg, 2);
            }

            // Map verbal rating scale based on average score:
            // 1.00 - 1.75 = Buruk
            // 1.76 - 2.50 = Sedang
            // 2.51 - 3.25 = Baik
            // 3.26 - 4.00 = Sangat Baik
            $verbalRating = 'Belum Dinilai';
            if ($totalEvaluations > 0) {
                if ($averageScore <= 1.75) {
                    $verbalRating = 'Buruk';
                } elseif ($averageScore <= 2.50) {
                    $verbalRating = 'Sedang';
                } elseif ($averageScore <= 3.25) {
                    $verbalRating = 'Baik';
                } else {
                    $verbalRating = 'Sangat Baik';
                }
            }

            $summary[] = [
                'member' => $member,
                'total_reviews' => $totalEvaluations,
                'average_score' => $averageScore,
                'verbal_rating' => $verbalRating
            ];
        }

        return $summary;
    }

    /**
     * Get details of evaluations for a specific user to display in admin dashboard.
     */
    public function getMemberDetailsReport(int $memberId, ?int $scheduleId = null)
    {
        $member = User::findOrFail($memberId);
        $evaluations = $this->getEvaluationsReceivedByUser($memberId, $scheduleId);

        // Calculate average score per question
        $questions = $this->getQuestions();
        $questionAverages = [];

        foreach ($questions as $question) {
            $avgScore = 0;
            $count = 0;
            foreach ($evaluations as $eval) {
                $scoreObj = $eval->scores->where('question_id', $question->id)->first();
                if ($scoreObj) {
                    $avgScore += $scoreObj->score;
                    $count++;
                }
            }
            $questionAverages[] = [
                'question' => $question->question_text,
                'avg_score' => $count > 0 ? round($avgScore / $count, 2) : 0
            ];
        }

        return [
            'member' => $member,
            'evaluations' => $evaluations,
            'question_averages' => $questionAverages
        ];
    }
}
