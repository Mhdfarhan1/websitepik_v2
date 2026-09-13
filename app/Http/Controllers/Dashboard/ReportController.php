<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = $this->reportService->getPaginatedItems(10);
        return view('pages.dashboard.reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.reports.create');
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'order_index' => 'nullable|integer',
        ]);

        $this->reportService->createItem($validated);

        return redirect()->route('dashboard.reports.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        return view('pages.dashboard.reports.edit', compact('report'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'desc2' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'order_index' => 'nullable|integer',
        ]);

        $this->reportService->updateItem($report, $validated);

        return redirect()->route('dashboard.reports.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $this->reportService->deleteItem($report);

        return redirect()->route('dashboard.reports.index')->with('success', 'Laporan berhasil dihapus.');
    }

    /**
     * Show the settings form for Laporan page
     */
    public function settings()
    {
        $settings = $this->reportService->getSettings();
        return view('pages.dashboard.reports.settings', compact('settings'));
    }

    /**
     * Update settings for Laporan page
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'hero_title_1' => 'nullable|string|max:255',
            'hero_title_2' => 'nullable|string|max:255',
            'hero_desc' => 'nullable|string',
            'hero_bg' => 'nullable|image|max:10240',
        ]);

        $this->reportService->updateSettings($validated);

        return redirect()->route('dashboard.reports.settings')->with('success', 'Pengaturan Halaman Laporan berhasil diperbarui.');
    }
}
