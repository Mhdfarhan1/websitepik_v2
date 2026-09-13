<?php

namespace App\Services;

use App\Models\WorkProgram;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class WorkProgramService
{
    /**
     * Get all work programs sorted by order index.
     */
    public function getAllWorkPrograms(): Collection
    {
        return WorkProgram::orderBy('order_index', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get paginated work programs.
     */
    public function getPaginatedWorkPrograms(int $perPage = 10): LengthAwarePaginator
    {
        return WorkProgram::orderBy('order_index', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Create a new work program.
     */
    public function createWorkProgram(array $data): WorkProgram
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = app(\App\Services\ImageCompressionService::class)->compressAndUpload(
                file: $data['image'],
                directory: 'work_programs',
                maxWidth: 1920,
                quality: 80,
                disk: 'public'
            );
        }

        return WorkProgram::create($data);
    }

    /**
     * Update an existing work program.
     */
    public function updateWorkProgram(WorkProgram $workProgram, array $data): WorkProgram
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($workProgram->image) {
                app(\App\Services\ImageCompressionService::class)->delete($workProgram->image, disk: 'public');
            }
            $data['image'] = app(\App\Services\ImageCompressionService::class)->compressAndUpload(
                file: $data['image'],
                directory: 'work_programs',
                maxWidth: 1920,
                quality: 80,
                disk: 'public'
            );
        }

        $workProgram->update($data);

        return $workProgram;
    }

    /**
     * Delete a work program.
     */
    public function deleteWorkProgram(WorkProgram $workProgram): bool
    {
        if ($workProgram->image) {
            app(\App\Services\ImageCompressionService::class)->delete($workProgram->image, disk: 'public');
        }

        return $workProgram->delete();
    }

    /**
     * Get Proker page settings
     */
    public function getSettings(): array
    {
        $path = storage_path('app/proker_settings.json');
        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true);
        }
        return [
            'hero_title_1' => 'Program Kerja',
            'hero_title_2' => 'Unggulan',
            'hero_desc' => 'PIK-R REQUEST SMAN 1 Tasik Putri Puyu menyelenggarakan sistem edukasi dan konseling remaja melalui berbagai macam program kerja & aksi nyata. Saat ini, program kerja kami diimplementasikan melalui metode Peer-to-Peer Learning yang bermitra langsung dengan pihak sekolah dan instansi terkait.',
            'hero_bg' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=1600',
        ];
    }

    /**
     * Update Proker page settings
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

        file_put_contents(storage_path('app/proker_settings.json'), json_encode($settings, JSON_PRETTY_PRINT));
    }
}

