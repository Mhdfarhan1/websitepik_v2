<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\PeerEvaluationService;
use App\Models\PeerEvaluationSchedule;
use App\Models\PeerEvaluationQuestion;
use Illuminate\Http\Request;

class PeerEvaluationAdminController extends Controller
{
    protected $evaluationService;

    public function __construct(PeerEvaluationService $evaluationService)
    {
        $this->evaluationService = $evaluationService;
    }

    /**
     * Display schedules and questions configuration.
     */
    public function index()
    {
        $schedules = $this->evaluationService->getAllSchedules();
        $questions = $this->evaluationService->getQuestions();

        return view('pages.dashboard.peer-evaluation.admin.index', compact('schedules', 'questions'));
    }

    /**
     * Store a new evaluation schedule.
     */
    public function storeSchedule(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        PeerEvaluationSchedule::create([
            'title' => $request->title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => false, // Default inactive
        ]);

        return back()->with('success', 'Jadwal penilaian berhasil ditambahkan!');
    }

    /**
     * Toggle active status of a schedule.
     */
    public function toggleScheduleActive($id)
    {
        $schedule = PeerEvaluationSchedule::findOrFail($id);

        if (!$schedule->is_active) {
            // Deactivate all other schedules first
            PeerEvaluationSchedule::where('id', '!=', $id)->update(['is_active' => false]);
            $schedule->update(['is_active' => true]);
            $msg = 'Jadwal penilaian berhasil diaktifkan!';
        } else {
            $schedule->update(['is_active' => false]);
            $msg = 'Jadwal penilaian berhasil dinonaktifkan!';
        }

        return back()->with('success', $msg);
    }

    /**
     * Delete schedule.
     */
    public function destroySchedule($id)
    {
        $schedule = PeerEvaluationSchedule::findOrFail($id);
        $schedule->delete();

        return back()->with('success', 'Jadwal penilaian berhasil dihapus!');
    }

    /**
     * Store new question.
     */
    public function storeQuestion(Request $request)
    {
        $request->validate([
            'question_text' => 'required|string|max:500',
        ]);

        PeerEvaluationQuestion::create([
            'question_text' => $request->question_text,
        ]);

        return back()->with('success', 'Pertanyaan berhasil ditambahkan!');
    }

    /**
     * Update question text.
     */
    public function updateQuestion(Request $request, $id)
    {
        $request->validate([
            'question_text' => 'required|string|max:500',
        ]);

        $question = PeerEvaluationQuestion::findOrFail($id);
        $question->update([
            'question_text' => $request->question_text,
        ]);

        return back()->with('success', 'Pertanyaan berhasil diperbarui!');
    }

    /**
     * Delete question.
     */
    public function destroyQuestion($id)
    {
        $question = PeerEvaluationQuestion::findOrFail($id);
        $question->delete();

        return back()->with('success', 'Pertanyaan berhasil dihapus!');
    }

    /**
     * Show general results summary.
     */
    public function results(Request $request)
    {
        $schedules = $this->evaluationService->getAllSchedules();
        $selectedScheduleId = $request->input('schedule_id');

        // Default to active schedule if none selected
        if (!$selectedScheduleId) {
            $activeSchedule = $this->evaluationService->getActiveSchedule();
            $selectedScheduleId = $activeSchedule ? $activeSchedule->id : ($schedules->first() ? $schedules->first()->id : null);
        }

        $summary = $this->evaluationService->getMembersEvaluationSummary($selectedScheduleId);

        return view('pages.dashboard.peer-evaluation.admin.results', compact('summary', 'schedules', 'selectedScheduleId'));
    }

    /**
     * Show detailed evaluations for a single member.
     */
    public function resultsDetail($memberId, Request $request)
    {
        $selectedScheduleId = $request->input('schedule_id');
        $report = $this->evaluationService->getMemberDetailsReport($memberId, $selectedScheduleId);

        return view('pages.dashboard.peer-evaluation.admin.results-detail', compact('report', 'selectedScheduleId'));
    }
}
