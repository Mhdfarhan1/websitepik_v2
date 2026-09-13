<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\ImageCompressionService;
use Illuminate\Http\Request;

class MediaOptimizerController extends Controller
{
    protected ImageCompressionService $optimizerService;

    public function __construct(ImageCompressionService $optimizerService)
    {
        $this->optimizerService = $optimizerService;
    }

    /**
     * Display the Media Optimizer & Storage dashboard.
     */
    public function index()
    {
        $stats = $this->optimizerService->getStorageStats();
        return view('pages.dashboard.media-optimizer.index', compact('stats'));
    }

    /**
     * Simulate live compression for an uploaded image.
     */
    public function simulate(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:20480', // Up to 20MB
        ]);

        $result = $this->optimizerService->simulate($request->file('image'));
        return response()->json($result);
    }

    /**
     * Batch optimize all existing images in storage.
     */
    public function batchOptimize(Request $request)
    {
        $thresholdKb = (int) $request->input('threshold', 400); // files > 400KB
        $result = $this->optimizerService->optimizeExistingFiles($thresholdKb * 1024);

        if ($result['optimized_count'] > 0) {
            $msg = "Berhasil mengompresi {$result['optimized_count']} gambar dan menghemat {$result['bytes_saved_formatted']} ruang penyimpanan hosting!";
            return back()->with('success', $msg);
        }

        return back()->with('info', 'Semua gambar sudah dalam kondisi optimal atau berukuran di bawah batas!');
    }
}
