<?php

namespace App\Services;

use App\Models\LeaderHistory;
use App\Models\LeaderSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LeaderService
{
    protected ImageCompressionService $compressionService;

    public function __construct(ImageCompressionService $compressionService)
    {
        $this->compressionService = $compressionService;
    }

    /**
     * Get or create leader settings.
     */
    public function getSetting(): LeaderSetting
    {
        return LeaderSetting::firstOrCreate(
            ['id' => 1],
            [
                'badge_title' => 'ESTAFET KEPEMIMPINAN & DEDIKASI',
                'page_title' => 'Jejak Nakhoda PIK-R REQUEST',
                'subtitle' => 'Panggung kehormatan dan rekam jejak para Ketua yang telah mendedikasikan waktu, jiwa, dan raganya menakhodai perjalanan PIK-R REQUEST SMAN 1 Tasik Putri Puyu dari masa ke masa.',
                'audio_title' => 'Kenangan Terindah Pemimpin',
                'audio_artist' => 'Lagu Kenangan Estafet',
                'is_audio_active' => true,
            ]
        );
    }

    /**
     * Update leader setting & audio.
     */
    public function updateSetting(array $data, ?UploadedFile $audioFile = null, ?UploadedFile $bannerFile = null): LeaderSetting
    {
        $setting = $this->getSetting();

        if ($bannerFile) {
            if ($setting->banner_image && File::exists(public_path($setting->banner_image))) {
                @unlink(public_path($setting->banner_image));
            }
            $data['banner_image'] = $this->compressionService->compressAndUpload(
                file: $bannerFile,
                directory: 'uploads/leaders',
                maxWidth: 1600,
                quality: 85
            );
        }

        if (!empty($data['remove_audio'])) {
            if ($setting->audio_file && File::exists(public_path($setting->audio_file))) {
                @unlink(public_path($setting->audio_file));
            }
            $data['audio_file'] = null;
            unset($data['remove_audio']);
        } elseif ($audioFile) {
            if ($setting->audio_file && File::exists(public_path($setting->audio_file))) {
                @unlink(public_path($setting->audio_file));
            }

            $dir = public_path('uploads/leaders/audio');
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $filename = 'audio_leader_' . time() . '_' . Str::random(8) . '.' . $audioFile->getClientOriginalExtension();
            $audioFile->move($dir, $filename);
            $data['audio_file'] = 'uploads/leaders/audio/' . $filename;
        }

        $setting->update($data);
        return $setting->fresh();
    }

    /**
     * Get all leaders.
     */
    public function getAllLeaders(bool $onlyActive = true)
    {
        $query = LeaderHistory::query()
            ->orderBy('order_index', 'asc')
            ->orderBy('id', 'asc');

        if ($onlyActive) {
            $query->where('is_active', true);
        }

        return $query->get();
    }

    /**
     * Get leader by ID.
     */
    public function getLeaderById(int $id): LeaderHistory
    {
        return LeaderHistory::findOrFail($id);
    }

    /**
     * Store new leader.
     */
    public function storeLeader(array $data, ?UploadedFile $photoFile = null): LeaderHistory
    {
        if ($photoFile) {
            $data['photo'] = $this->compressionService->compressAndUpload(
                file: $photoFile,
                directory: 'uploads/leaders',
                maxWidth: 1000,
                quality: 85
            );
        }

        if (!isset($data['order_index']) || $data['order_index'] === null) {
            $data['order_index'] = (LeaderHistory::max('order_index') ?? 0) + 1;
        }

        $data['is_active'] = $data['is_active'] ?? true;

        return LeaderHistory::create($data);
    }

    /**
     * Update an existing leader.
     */
    public function updateLeader(int $id, array $data, ?UploadedFile $photoFile = null): LeaderHistory
    {
        $leader = LeaderHistory::findOrFail($id);

        if (!empty($data['remove_photo'])) {
            if ($leader->photo && File::exists(public_path($leader->photo))) {
                @unlink(public_path($leader->photo));
            }
            $data['photo'] = null;
            unset($data['remove_photo']);
        } elseif ($photoFile) {
            if ($leader->photo && File::exists(public_path($leader->photo))) {
                @unlink(public_path($leader->photo));
            }

            $data['photo'] = $this->compressionService->compressAndUpload(
                file: $photoFile,
                directory: 'uploads/leaders',
                maxWidth: 1000,
                quality: 85
            );
        }

        $leader->update($data);
        return $leader->fresh();
    }

    /**
     * Delete leader.
     */
    public function deleteLeader(int $id): bool
    {
        $leader = LeaderHistory::findOrFail($id);

        if ($leader->photo && File::exists(public_path($leader->photo))) {
            @unlink(public_path($leader->photo));
        }

        return $leader->delete();
    }

    /**
     * Reorder leaders order_index.
     */
    public function reorderLeaders(array $orderIds): void
    {
        foreach ($orderIds as $index => $id) {
            LeaderHistory::where('id', $id)->update(['order_index' => $index + 1]);
        }
    }
}
