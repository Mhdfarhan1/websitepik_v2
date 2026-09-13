<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageCompressionService
{
    protected ?ImageManager $manager = null;

    public function __construct()
    {
        try {
            $this->manager = new ImageManager(new Driver());
        } catch (\Throwable $e) {
            Log::warning('ImageCompressionService: Failed to initialize Intervention Image with GD driver. Fallback to basic file move.', [
                'error' => $e->getMessage()
            ]);
            $this->manager = null;
        }
    }

    /**
     * Compress and upload an image.
     * 
     * @param UploadedFile $file
     * @param string $directory Directory relative to public_path (if $disk is null) or relative to storage disk
     * @param int $maxWidth Max width/height to scale down to (maintains aspect ratio)
     * @param int $quality Compression quality (1-100, default 80 is optimal)
     * @param string|null $disk Storage disk name (null for public_path('uploads/...'), or 'public' for Storage::disk('public'))
     * @param bool $convertToWebp Whether to convert JPEG/PNG to modern WebP
     * @return string Path to be stored in database
     */
    public function compressAndUpload(
        UploadedFile $file,
        string $directory = 'uploads',
        int $maxWidth = 1920,
        int $quality = 80,
        ?string $disk = null,
        bool $convertToWebp = true
    ): string {
        $extension = strtolower($file->getClientOriginalExtension());
        $mime = $file->getMimeType();

        // Non-image files or formats that should not be rasterized (SVG, animated GIF)
        if ($extension === 'svg' || str_contains($mime, 'svg') || $extension === 'gif') {
            return $this->fallbackSave($file, $directory, $disk);
        }

        // If Intervention Image is not available, fallback to basic move
        if (!$this->manager) {
            return $this->fallbackSave($file, $directory, $disk);
        }

        try {
            // Read and decode the image
            $image = $this->manager->decode($file->getRealPath());

            // Auto-orient based on EXIF metadata (crucial for smartphone camera photos)
            try {
                $image->orient();
            } catch (\Throwable $orientError) {
                // Ignore if EXIF orientation is not present
            }

            // Downscale proportionally if width or height exceeds maximum
            $image->scaleDown(width: $maxWidth, height: $maxWidth);

            // Determine target extension & filename
            $targetExtension = $convertToWebp ? 'webp' : ($extension ?: 'jpg');
            $filename = uniqid('img_') . '_' . time() . '.' . $targetExtension;

            if ($disk) {
                // Save using Laravel Storage disk (e.g. Storage::disk('public'))
                $relativePath = trim($directory, '/') . '/' . $filename;
                $absolutePath = Storage::disk($disk)->path($relativePath);
                
                $dirPath = dirname($absolutePath);
                if (!File::exists($dirPath)) {
                    File::makeDirectory($dirPath, 0755, true);
                }

                $image->save($absolutePath, quality: $quality);
                return $relativePath;
            } else {
                // Save to public directory
                $destinationDir = public_path(trim($directory, '/'));
                if (!File::exists($destinationDir)) {
                    File::makeDirectory($destinationDir, 0755, true, true);
                }

                $absolutePath = $destinationDir . DIRECTORY_SEPARATOR . $filename;
                $image->save($absolutePath, quality: $quality);

                // If public_path is different from project public (e.g. cPanel public_html), also mirror file to project public
                $projectPublicDir = base_path('public/' . trim($directory, '/'));
                if (realpath($destinationDir) !== realpath($projectPublicDir)) {
                    try {
                        if (!File::exists($projectPublicDir)) {
                            File::makeDirectory($projectPublicDir, 0755, true, true);
                        }
                        @copy($absolutePath, $projectPublicDir . DIRECTORY_SEPARATOR . $filename);
                    } catch (\Throwable $e) {
                        // Suppress mirroring failure
                    }
                }

                return trim($directory, '/') . '/' . $filename;
            }
        } catch (\Throwable $e) {
            Log::error('ImageCompressionService compression failed, using fallback save: ' . $e->getMessage(), [
                'file' => $file->getClientOriginalName()
            ]);
            return $this->fallbackSave($file, $directory, $disk);
        }
    }

    /**
     * Fallback standard file save without compression if anything goes wrong.
     */
    protected function fallbackSave(UploadedFile $file, string $directory, ?string $disk = null): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = uniqid('file_') . '_' . time() . '.' . $extension;

        if ($disk) {
            return $file->storeAs(trim($directory, '/'), $filename, $disk);
        } else {
            $destinationDir = public_path(trim($directory, '/'));
            if (!File::exists($destinationDir)) {
                File::makeDirectory($destinationDir, 0755, true, true);
            }
            $targetPath = $destinationDir . DIRECTORY_SEPARATOR . $filename;
            $file->move($destinationDir, $filename);

            // Mirror to project public if running in cPanel public_html
            $projectPublicDir = base_path('public/' . trim($directory, '/'));
            if (realpath($destinationDir) !== realpath($projectPublicDir)) {
                try {
                    if (!File::exists($projectPublicDir)) {
                        File::makeDirectory($projectPublicDir, 0755, true, true);
                    }
                    @copy($targetPath, $projectPublicDir . DIRECTORY_SEPARATOR . $filename);
                } catch (\Throwable $e) {
                    // Suppress mirroring failure
                }
            }

            return trim($directory, '/') . '/' . $filename;
        }
    }

    /**
     * Safely delete an image file from disk.
     */
    public function delete(?string $path, ?string $disk = null): void
    {
        if (!$path) {
            return;
        }

        try {
            if ($disk) {
                if (Storage::disk($disk)->exists($path)) {
                    Storage::disk($disk)->delete($path);
                }
            } else {
                $fullPath = public_path($path);
                if (File::exists($fullPath) && is_file($fullPath)) {
                    File::delete($fullPath);
                }

                // Also clean from project public if different
                $projectFullPath = base_path('public/' . ltrim($path, '/\\'));
                if (realpath($fullPath) !== realpath($projectFullPath) && File::exists($projectFullPath) && is_file($projectFullPath)) {
                    File::delete($projectFullPath);
                }
            }
        } catch (\Throwable $e) {
            Log::warning('ImageCompressionService delete failed: ' . $e->getMessage(), ['path' => $path]);
        }
    }

    /**
     * Calculate current storage statistics for media files.
     */
    public function getStorageStats(): array
    {
        $scanPaths = [
            'public_uploads' => public_path('uploads'),
            'storage_public' => storage_path('app/public'),
        ];

        $totalFiles = 0;
        $totalBytes = 0;
        $formats = [
            'webp' => 0,
            'jpeg_jpg' => 0,
            'png' => 0,
            'other' => 0,
        ];
        $largeFilesCount = 0; // Files > 800 KB

        foreach ($scanPaths as $basePath) {
            if (!File::exists($basePath)) {
                continue;
            }

            $allFiles = File::allFiles($basePath);
            foreach ($allFiles as $file) {
                $ext = strtolower($file->getExtension());
                $size = $file->getSize();

                if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'])) {
                    $totalFiles++;
                    $totalBytes += $size;

                    if ($ext === 'webp') {
                        $formats['webp']++;
                    } elseif ($ext === 'jpg' || $ext === 'jpeg') {
                        $formats['jpeg_jpg']++;
                    } elseif ($ext === 'png') {
                        $formats['png']++;
                    } else {
                        $formats['other']++;
                    }

                    if ($size > 800 * 1024) {
                        $largeFilesCount++;
                    }
                }
            }
        }

        return [
            'total_files' => $totalFiles,
            'total_bytes' => $totalBytes,
            'total_formatted' => $this->formatBytes($totalBytes),
            'avg_size_formatted' => $totalFiles > 0 ? $this->formatBytes($totalBytes / $totalFiles) : '0 KB',
            'large_files_count' => $largeFilesCount,
            'formats' => $formats,
            'gd_available' => extension_loaded('gd'),
            'webp_supported' => function_exists('imagewebp'),
        ];
    }

    /**
     * Helper to format bytes to human readable format (KB, MB, GB).
     */
    public function formatBytes(int|float $bytes, int $precision = 2): string
    {
        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = min((int) floor(log($bytes, 1024)), count($units) - 1);
        $value = $bytes / pow(1024, $power);

        return round($value, $precision) . ' ' . $units[$power];
    }

    /**
     * Optimize an uploaded file in memory for simulation / preview in admin.
     */
    public function simulate(UploadedFile $file, int $maxWidth = 1920, int $quality = 80): array
    {
        $originalSize = $file->getSize();
        $originalName = $file->getClientOriginalName();
        $originalExt = strtolower($file->getClientOriginalExtension());

        if (!$this->manager) {
            return [
                'success' => false,
                'message' => 'Intervention Image tidak tersedia.',
            ];
        }

        try {
            $image = $this->manager->decode($file->getRealPath());
            $origWidth = $image->width();
            $origHeight = $image->height();

            try {
                $image->orient();
            } catch (\Throwable $e) {}

            $image->scaleDown(width: $maxWidth, height: $maxWidth);
            $newWidth = $image->width();
            $newHeight = $image->height();

            // Encode to webp in memory
            $encoded = $image->encodeUsingFormat('webp', quality: $quality);
            $compressedSize = strlen((string) $encoded);
            $base64Data = 'data:image/webp;base64,' . base64_encode((string) $encoded);

            $savedBytes = max(0, $originalSize - $compressedSize);
            $savedPercent = $originalSize > 0 ? round(($savedBytes / $originalSize) * 100, 1) : 0;

            return [
                'success' => true,
                'original_name' => $originalName,
                'original_ext' => $originalExt,
                'original_size' => $originalSize,
                'original_size_formatted' => $this->formatBytes($originalSize),
                'original_dimensions' => "{$origWidth} x {$origHeight} px",
                'compressed_size' => $compressedSize,
                'compressed_size_formatted' => $this->formatBytes($compressedSize),
                'compressed_dimensions' => "{$newWidth} x {$newHeight} px",
                'saved_bytes_formatted' => $this->formatBytes($savedBytes),
                'saved_percentage' => $savedPercent,
                'preview_data' => $base64Data,
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Gagal mengompresi gambar: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Optimize existing media files on disk in-place.
     * Keeps same filename so all database references and links remain intact.
     * 
     * @param int $thresholdBytes Files larger than this threshold will be compressed (default 400 KB)
     * @param int $maxWidth Max dimension (default 1920px)
     * @param int $quality Compression quality (default 80)
     * @return array Summary of optimization results
     */
    public function optimizeExistingFiles(int $thresholdBytes = 409600, int $maxWidth = 1920, int $quality = 80): array
    {
        if (!$this->manager) {
            return [
                'success' => false,
                'message' => 'Driver kompresi tidak tersedia.',
                'optimized_count' => 0,
                'bytes_saved' => 0,
                'bytes_saved_formatted' => '0 B',
            ];
        }

        $scanPaths = [
            public_path('uploads'),
            storage_path('app/public'),
        ];

        $optimizedCount = 0;
        $totalSavedBytes = 0;
        $details = [];

        foreach ($scanPaths as $basePath) {
            if (!File::exists($basePath)) {
                continue;
            }

            $allFiles = File::allFiles($basePath);
            foreach ($allFiles as $file) {
                $ext = strtolower($file->getExtension());
                $size = $file->getSize();

                // Only optimize raster images that are larger than the threshold
                if (in_array($ext, ['jpg', 'jpeg', 'png']) && $size > $thresholdBytes) {
                    $filePath = $file->getRealPath();

                    try {
                        $image = $this->manager->decode($filePath);
                        
                        try {
                            $image->orient();
                        } catch (\Throwable $e) {}

                        $image->scaleDown(width: $maxWidth, height: $maxWidth);

                        // Save in-place with optimal compression
                        $image->save($filePath, quality: $quality);

                        // Clear file stat cache and check new size
                        clearstatcache(true, $filePath);
                        $newSize = filesize($filePath);

                        if ($newSize < $size) {
                            $saved = $size - $newSize;
                            $totalSavedBytes += $saved;
                            $optimizedCount++;

                            $details[] = [
                                'file' => $file->getFilename(),
                                'old_size' => $this->formatBytes($size),
                                'new_size' => $this->formatBytes($newSize),
                                'saved' => $this->formatBytes($saved),
                            ];
                        }
                    } catch (\Throwable $e) {
                        Log::warning('Batch optimize skipped file due to error: ' . $e->getMessage(), ['file' => $filePath]);
                    }
                }
            }
        }

        return [
            'success' => true,
            'optimized_count' => $optimizedCount,
            'bytes_saved' => $totalSavedBytes,
            'bytes_saved_formatted' => $this->formatBytes($totalSavedBytes),
            'details' => $details,
        ];
    }
}
