<?php

namespace App\Services;

use App\Models\Report;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportService
{
    /**
     * Get all items sorted by order index.
     */
    public function getAllItems(): Collection
    {
        return Report::orderBy('order_index', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get paginated items.
     */
    public function getPaginatedItems(int $perPage = 10): LengthAwarePaginator
    {
        return Report::orderBy('order_index', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Create a new item.
     */
    public function createItem(array $data): Report
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = app(\App\Services\ImageCompressionService::class)->compressAndUpload(
                file: $data['image'],
                directory: 'reports/images',
                maxWidth: 1920,
                quality: 80,
                disk: 'public'
            );
        }
        if (isset($data['document']) && $data['document'] instanceof \Illuminate\Http\UploadedFile) {
            $data['document'] = $data['document']->store('reports/documents', 'public');
        }

        return Report::create($data);
    }

    /**
     * Update an existing item.
     */
    public function updateItem(Report $report, array $data): Report
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($report->image) {
                app(\App\Services\ImageCompressionService::class)->delete($report->image, disk: 'public');
            }
            $data['image'] = app(\App\Services\ImageCompressionService::class)->compressAndUpload(
                file: $data['image'],
                directory: 'reports/images',
                maxWidth: 1920,
                quality: 80,
                disk: 'public'
            );
        }
        if (isset($data['document']) && $data['document'] instanceof \Illuminate\Http\UploadedFile) {
            if ($report->document) {
                Storage::disk('public')->delete($report->document);
            }
            $data['document'] = $data['document']->store('reports/documents', 'public');
        }

        $report->update($data);

        return $report;
    }

    /**
     * Delete an item.
     */
    public function deleteItem(Report $report): bool
    {
        if ($report->image) {
            app(\App\Services\ImageCompressionService::class)->delete($report->image, disk: 'public');
        }
        if ($report->document) {
            Storage::disk('public')->delete($report->document);
        }

        return $report->delete();
    }

    /**
     * Get Laporan page settings
     */
    public function getSettings(): array
    {
        $path = storage_path('app/laporan_settings.json');
        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true);
        }
        return [
            'hero_title_1' => 'Transparansi &',
            'hero_title_2' => 'Laporan',
            'hero_desc' => 'Sebagai bentuk akuntabilitas publik, PIK-R REQUEST SMAN 1 Tasik Putri Puyu menyajikan berbagai laporan berkala yang mencakup capaian program kerja, statistik layanan, hingga transparansi tata kelola organisasi.',
            'hero_bg' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&q=80&w=1600',
        ];
    }

    /**
     * Update Laporan page settings
     */
    public function updateSettings(array $data): void
    {
        $settings = $this->getSettings();
        
        $settings['hero_title_1'] = $data['hero_title_1'] ?? $settings['hero_title_1'];
        $settings['hero_title_2'] = $data['hero_title_2'] ?? $settings['hero_title_2'];
        $settings['hero_desc'] = $data['hero_desc'] ?? $settings['hero_desc'];

        if (isset($data['hero_bg']) && $data['hero_bg'] instanceof \Illuminate\Http\UploadedFile) {
            $path = $data['hero_bg']->store('appearance', 'public');
            $settings['hero_bg'] = 'storage/' . $path;
        }

        file_put_contents(storage_path('app/laporan_settings.json'), json_encode($settings, JSON_PRETTY_PRINT));
    }
}
