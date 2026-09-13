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

    /**
     * Synchronize media uploads & repair storage links for cPanel hosting.
     */
    public function syncCpanelStorage(Request $request)
    {
        $syncedFiles = 0;
        $projectUploads = base_path('public/uploads');
        $activeUploads = public_path('uploads');

        // 1. Ensure active upload directories exist
        $folders = ['gallery', 'news', 'achievements', 'appearance', 'profile', 'structures', 'documents'];
        foreach ($folders as $folder) {
            $dir = $activeUploads . DIRECTORY_SEPARATOR . $folder;
            if (!\Illuminate\Support\Facades\File::exists($dir)) {
                \Illuminate\Support\Facades\File::makeDirectory($dir, 0755, true, true);
            }
        }

        // 2. Sync all files from project public to active public if different
        if (\Illuminate\Support\Facades\File::exists($projectUploads) && realpath($projectUploads) !== realpath($activeUploads)) {
            $files = \Illuminate\Support\Facades\File::allFiles($projectUploads);
            foreach ($files as $file) {
                $relativePath = $file->getRelativePathname();
                $targetFile = $activeUploads . DIRECTORY_SEPARATOR . $relativePath;
                $targetDir = dirname($targetFile);

                if (!\Illuminate\Support\Facades\File::exists($targetDir)) {
                    \Illuminate\Support\Facades\File::makeDirectory($targetDir, 0755, true, true);
                }

                if (!file_exists($targetFile) || filemtime($file->getRealPath()) > filemtime($targetFile)) {
                    if (@copy($file->getRealPath(), $targetFile)) {
                        $syncedFiles++;
                    }
                }
            }
        }

        // 3. Check & fix storage symlink
        $symlinkStatus = 'OK';
        $storageTarget = storage_path('app/public');
        $publicStorage = public_path('storage');

        if (!file_exists($storageTarget)) {
            \Illuminate\Support\Facades\File::makeDirectory($storageTarget, 0755, true, true);
        }

        if (is_link($publicStorage)) {
            // Check if link target is broken
            $target = @readlink($publicStorage);
            if (!$target || !file_exists($publicStorage)) {
                @unlink($publicStorage);
                if (@symlink($storageTarget, $publicStorage)) {
                    $symlinkStatus = 'Symlink diperbaiki';
                } else {
                    $symlinkStatus = 'Fallback route aktif';
                }
            }
        } elseif (!file_exists($publicStorage)) {
            if (@symlink($storageTarget, $publicStorage)) {
                $symlinkStatus = 'Symlink berhasil dibuat';
            } else {
                $symlinkStatus = 'Fallback route aktif';
            }
        }

        $msg = "Sinkronisasi selesai! {$syncedFiles} file media berhasil disinkronkan ke direktori publik. Status Storage: {$symlinkStatus}. Gambar di hosting sekarang dapat diakses dengan lancar.";
        return back()->with('success', $msg);
    }
}
