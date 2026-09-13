<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\StatisticService;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    protected $statisticService;

    public function __construct(StatisticService $statisticService)
    {
        $this->statisticService = $statisticService;
    }

    /**
     * Show the settings form for Statistik page
     */
    public function settings()
    {
        $settings = $this->statisticService->getSettings();
        return view('pages.dashboard.statistics.settings', compact('settings'));
    }

    /**
     * Update settings for Statistik page
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'total_remaja' => 'required|integer',
            'target_edukasi_tahunan' => 'required|numeric|min:1',
            'total_remaja_trend' => 'nullable|string|max:255',
            'sesi_konseling' => 'required|integer',
            'sesi_konseling_trend' => 'nullable|string|max:255',
            'kegiatan_edukasi' => 'required|integer',
            'kegiatan_edukasi_trend' => 'required|string',
            
            'demo_kelas_x' => 'required|integer|min:0|max:100',
            'demo_kelas_xi' => 'required|integer|min:0|max:100',
            'demo_kelas_xii' => 'required|integer|min:0|max:100',
            
            'topik_1_nama' => 'required|string',
            'topik_1_desc' => 'required|string',
            'topik_1_pct' => 'required|integer|min:0|max:100',
            
            'topik_2_nama' => 'required|string',
            'topik_2_desc' => 'required|string',
            'topik_2_pct' => 'required|integer|min:0|max:100',
            
            'topik_3_nama' => 'required|string',
            'topik_3_desc' => 'required|string',
            'topik_3_pct' => 'required|integer|min:0|max:100',
            
            'statistik_bg' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($request->hasFile('statistik_bg')) {
            $path = $request->file('statistik_bg')->store('statistik', 'public');
            $validated['statistik_bg'] = $path;
        } else {
            // Keep existing if not uploaded
            $existing = $this->statisticService->getSettings();
            $validated['statistik_bg'] = $existing['statistik_bg'] ?? '';
        }

        $this->statisticService->updateSettings($validated);

        return redirect()->route('dashboard.statistics.settings')->with('success', 'Data Statistik berhasil diperbarui.');
    }
}
