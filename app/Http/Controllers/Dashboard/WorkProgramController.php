<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\WorkProgram;
use App\Services\WorkProgramService;
use Illuminate\Http\Request;

class WorkProgramController extends Controller
{
    protected $workProgramService;

    public function __construct(WorkProgramService $workProgramService)
    {
        $this->workProgramService = $workProgramService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workPrograms = $this->workProgramService->getPaginatedWorkPrograms(10);
        return view('pages.dashboard.work_programs.index', compact('workPrograms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.work_programs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'desc2' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'order_index' => 'nullable|integer',
        ]);

        $this->workProgramService->createWorkProgram($validated);

        return redirect()->route('dashboard.work-programs.index')->with('success', 'Program Kerja berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkProgram $workProgram)
    {
        return view('pages.dashboard.work_programs.edit', compact('workProgram'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkProgram $workProgram)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'desc2' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'order_index' => 'nullable|integer',
        ]);

        $this->workProgramService->updateWorkProgram($workProgram, $validated);

        return redirect()->route('dashboard.work-programs.index')->with('success', 'Program Kerja berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkProgram $workProgram)
    {
        $this->workProgramService->deleteWorkProgram($workProgram);

        return redirect()->route('dashboard.work-programs.index')->with('success', 'Program Kerja berhasil dihapus.');
    }

    /**
     * Show the settings form for Proker page
     */
    public function settings()
    {
        $settings = $this->workProgramService->getSettings();
        return view('pages.dashboard.work_programs.settings', compact('settings'));
    }

    /**
     * Update settings for Proker page
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'hero_title_1' => 'nullable|string|max:255',
            'hero_title_2' => 'nullable|string|max:255',
            'hero_desc' => 'nullable|string',
            'hero_bg' => 'nullable|image|max:10240',
        ]);

        $this->workProgramService->updateSettings($validated);

        return redirect()->route('dashboard.work-programs.settings')->with('success', 'Pengaturan Halaman Program Kerja berhasil diperbarui.');
    }
}

