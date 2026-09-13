<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\PeerEvaluationService;
use App\Models\User;
use Illuminate\Http\Request;

class PeerEvaluationMemberController extends Controller
{
    protected $evaluationService;

    public function __construct(PeerEvaluationService $evaluationService)
    {
        $this->evaluationService = $evaluationService;
    }

    /**
     * Show peer evaluation dashboard for member.
     */
    public function index()
    {
        $user = auth()->user();
        $activeSchedule = $this->evaluationService->getActiveSchedule();
        $questions = $this->evaluationService->getQuestions();

        // Get peer evaluations received by current user
        $receivedEvaluations = $this->evaluationService->getEvaluationsReceivedByUser($user->id);
        
        // Calculate dynamic averages for this user
        $avgScore = 0;
        if ($receivedEvaluations->count() > 0) {
            $scoreSum = 0;
            $scoreCount = 0;
            foreach ($receivedEvaluations as $eval) {
                foreach ($eval->scores as $score) {
                    $scoreSum += $score->score;
                    $scoreCount++;
                }
            }
            $avgScore = $scoreCount > 0 ? round($scoreSum / $scoreCount, 2) : 0;
        }

        // Map verbal rating scale based on average score:
        $verbalRating = 'Belum Dinilai';
        if ($receivedEvaluations->count() > 0) {
            if ($avgScore <= 1.75) {
                $verbalRating = 'Buruk';
            } elseif ($avgScore <= 2.50) {
                $verbalRating = 'Sedang';
            } elseif ($avgScore <= 3.25) {
                $verbalRating = 'Baik';
            } else {
                $verbalRating = 'Sangat Baik';
            }
        }

        // Peers listing if schedule is active
        $peers = collect();
        $evaluatedPeerIds = [];
        if ($activeSchedule) {
            $peers = $this->evaluationService->getEvaluatees($user->id);
            $evaluatedPeerIds = $this->evaluationService->getEvaluatedPeerIds($user->id, $activeSchedule->id);
        }

        return view('pages.dashboard.peer-evaluation.member.index', compact(
            'activeSchedule',
            'questions',
            'receivedEvaluations',
            'avgScore',
            'verbalRating',
            'peers',
            'evaluatedPeerIds'
        ));
    }

    /**
     * Show form to evaluate a peer.
     */
    public function evaluate($peerId)
    {
        $evaluator = auth()->user();
        $activeSchedule = $this->evaluationService->getActiveSchedule();

        if (!$activeSchedule) {
            return redirect()->route('dashboard.peer-evaluation.index')
                ->with('error', 'Tidak ada jadwal kuesioner penilaian yang sedang aktif.');
        }

        if ($evaluator->id == $peerId) {
            return redirect()->route('dashboard.peer-evaluation.index')
                ->with('error', 'Anda tidak dapat memberikan penilaian untuk diri sendiri.');
        }

        $peer = User::where('role', '!=', 'super_admin')->findOrFail($peerId);

        // Check if already evaluated in this schedule
        $evaluatedPeerIds = $this->evaluationService->getEvaluatedPeerIds($evaluator->id, $activeSchedule->id);
        if (in_array($peerId, $evaluatedPeerIds)) {
            return redirect()->route('dashboard.peer-evaluation.index')
                ->with('error', 'Anda sudah memberikan penilaian untuk anggota ini.');
        }

        $questions = $this->evaluationService->getQuestions();

        return view('pages.dashboard.peer-evaluation.member.evaluate', compact('activeSchedule', 'peer', 'questions'));
    }

    /**
     * Submit peer evaluation score.
     */
    public function submit(Request $request, $peerId)
    {
        $evaluator = auth()->user();
        $activeSchedule = $this->evaluationService->getActiveSchedule();

        if (!$activeSchedule) {
            return redirect()->route('dashboard.peer-evaluation.index')
                ->with('error', 'Tidak ada jadwal kuesioner penilaian yang aktif.');
        }

        $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'required|integer|between:1,4', // 1: Buruk, 2: Sedang, 3: Baik, 4: Sangat Baik
            'comment' => 'nullable|string|max:1000',
        ]);

        try {
            $this->evaluationService->submitEvaluation(
                $evaluator->id,
                $peerId,
                $activeSchedule->id,
                $request->scores,
                $request->comment
            );

            return redirect()->route('dashboard.peer-evaluation.index')
                ->with('success', 'Penilaian berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard.peer-evaluation.index')
                ->with('error', $e->getMessage());
        }
    }
}
