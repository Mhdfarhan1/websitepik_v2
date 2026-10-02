<?php

namespace App\Services;

use App\Models\TimeCapsule;
use App\Models\TimeCapsuleItem;
use App\Models\TimeCapsuleSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TimeCapsuleService
{
    protected ImageCompressionService $compressionService;

    public function __construct(ImageCompressionService $compressionService)
    {
        $this->compressionService = $compressionService;
    }

    /**
     * Get or create global settings for Kotak Waktu.
     */
    public function getSetting(): TimeCapsuleSetting
    {
        return TimeCapsuleSetting::firstOrCreate(
            ['id' => 1],
            [
                'badge_title' => 'RUANG ARSIP DIGITAL MASA DEPAN',
                'page_title' => '🔐 Kotak Waktu PIK-R',
                'subtitle' => '“Tidak semua cerita harus dibaca hari ini. Beberapa cerita sengaja kita tinggalkan untuk masa depan.”',
                'audio_title' => 'Melodi Penjaga Waktu',
                'audio_artist' => 'PIK-R REQUEST',
                'is_audio_active' => true,
            ]
        );
    }

    /**
     * Update global settings and audio.
     */
    public function updateSetting(array $data, ?UploadedFile $audioFile = null, ?UploadedFile $bannerFile = null): TimeCapsuleSetting
    {
        $setting = $this->getSetting();

        if ($bannerFile) {
            if ($setting->banner_image && File::exists(public_path($setting->banner_image))) {
                @unlink(public_path($setting->banner_image));
            }
            $data['banner_image'] = $this->compressionService->compressAndUpload(
                file: $bannerFile,
                directory: 'uploads/time_capsules',
                maxWidth: 1920,
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

            $dir = public_path('uploads/time_capsules/audio');
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $filename = 'audio_capsule_' . time() . '_' . Str::random(8) . '.' . $audioFile->getClientOriginalExtension();
            $audioFile->move($dir, $filename);
            $data['audio_file'] = 'uploads/time_capsules/audio/' . $filename;
        }

        $setting->update($data);
        return $setting->fresh();
    }

    /**
     * Get all capsules.
     */
    public function getAllCapsules(bool $activeOnly = true): Collection
    {
        $query = TimeCapsule::with(['items'])
            ->withCount(['items', 'letters', 'stories', 'photos', 'videos'])
            ->orderBy('is_featured', 'desc')
            ->orderBy('order_index', 'asc')
            ->orderBy('created_date', 'desc');

        if ($activeOnly) {
            $query->where('is_active', true);
        }

        return $query->get();
    }

    /**
     * Find capsule by ID.
     */
    public function getCapsuleById(int $id): TimeCapsule
    {
        return TimeCapsule::with(['letters', 'stories', 'photos', 'videos'])
            ->withCount(['items', 'letters', 'stories', 'photos', 'videos'])
            ->findOrFail($id);
    }

    /**
     * Find capsule by slug.
     */
    public function getCapsuleBySlug(string $slug): ?TimeCapsule
    {
        return TimeCapsule::with(['letters', 'stories', 'photos', 'videos'])
            ->withCount(['items', 'letters', 'stories', 'photos', 'videos'])
            ->where('slug', $slug)
            ->first();
    }

    /**
     * Store new capsule.
     */
    public function storeCapsule(array $data, ?UploadedFile $coverFile = null): TimeCapsule
    {
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Ensure unique slug
        $baseSlug = $data['slug'];
        $count = 1;
        while (TimeCapsule::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $baseSlug . '-' . $count;
            $count++;
        }

        if ($coverFile) {
            $data['cover_image'] = $this->compressionService->compressAndUpload(
                file: $coverFile,
                directory: 'uploads/time_capsules/covers',
                maxWidth: 1200,
                quality: 80
            );
        }

        if (!empty($data['is_featured'])) {
            TimeCapsule::where('is_featured', true)->update(['is_featured' => false]);
        }

        return TimeCapsule::create($data);
    }

    /**
     * Update capsule.
     */
    public function updateCapsule(int $id, array $data, ?UploadedFile $coverFile = null): TimeCapsule
    {
        $capsule = $this->getCapsuleById($id);

        if (!empty($data['slug']) && $data['slug'] !== $capsule->slug) {
            $data['slug'] = Str::slug($data['slug']);
            $baseSlug = $data['slug'];
            $count = 1;
            while (TimeCapsule::where('slug', $data['slug'])->where('id', '!=', $id)->exists()) {
                $data['slug'] = $baseSlug . '-' . $count;
                $count++;
            }
        }

        if ($coverFile) {
            if ($capsule->cover_image && File::exists(public_path($capsule->cover_image))) {
                @unlink(public_path($capsule->cover_image));
            }
            $data['cover_image'] = $this->compressionService->compressAndUpload(
                file: $coverFile,
                directory: 'uploads/time_capsules/covers',
                maxWidth: 1200,
                quality: 80
            );
        }

        if (!empty($data['is_featured'])) {
            TimeCapsule::where('id', '!=', $id)->where('is_featured', true)->update(['is_featured' => false]);
        }

        $capsule->update($data);
        return $capsule->fresh();
    }

    /**
     * Delete capsule and associated files.
     */
    public function deleteCapsule(int $id): bool
    {
        $capsule = $this->getCapsuleById($id);

        if ($capsule->cover_image && File::exists(public_path($capsule->cover_image))) {
            @unlink(public_path($capsule->cover_image));
        }

        foreach ($capsule->items as $item) {
            if ($item->media_path && File::exists(public_path($item->media_path))) {
                @unlink(public_path($item->media_path));
            }
        }

        return $capsule->delete();
    }

    /**
     * Set capsule as featured.
     */
    public function setFeatured(int $id): void
    {
        TimeCapsule::where('is_featured', true)->update(['is_featured' => false]);
        TimeCapsule::where('id', $id)->update(['is_featured' => true]);
    }

    /**
     * Store item inside capsule.
     */
    public function storeItem(int $capsuleId, array $data, ?UploadedFile $mediaFile = null): TimeCapsuleItem
    {
        $data['time_capsule_id'] = $capsuleId;

        if ($mediaFile) {
            $type = $data['type'] ?? 'photo';
            if ($type === 'video') {
                $dir = public_path('uploads/time_capsules/videos');
                if (!File::exists($dir)) {
                    File::makeDirectory($dir, 0755, true);
                }
                $filename = 'video_' . time() . '_' . Str::random(8) . '.' . $mediaFile->getClientOriginalExtension();
                $mediaFile->move($dir, $filename);
                $data['media_path'] = 'uploads/time_capsules/videos/' . $filename;
            } else {
                $data['media_path'] = $this->compressionService->compressAndUpload(
                    file: $mediaFile,
                    directory: 'uploads/time_capsules/items',
                    maxWidth: 1600,
                    quality: 85
                );
            }
        }

        return TimeCapsuleItem::create($data);
    }

    /**
     * Update item.
     */
    public function updateItem(int $id, array $data, ?UploadedFile $mediaFile = null): TimeCapsuleItem
    {
        $item = TimeCapsuleItem::findOrFail($id);

        if ($mediaFile) {
            if ($item->media_path && File::exists(public_path($item->media_path))) {
                @unlink(public_path($item->media_path));
            }

            $type = $data['type'] ?? $item->type;
            if ($type === 'video') {
                $dir = public_path('uploads/time_capsules/videos');
                if (!File::exists($dir)) {
                    File::makeDirectory($dir, 0755, true);
                }
                $filename = 'video_' . time() . '_' . Str::random(8) . '.' . $mediaFile->getClientOriginalExtension();
                $mediaFile->move($dir, $filename);
                $data['media_path'] = 'uploads/time_capsules/videos/' . $filename;
            } else {
                $data['media_path'] = $this->compressionService->compressAndUpload(
                    file: $mediaFile,
                    directory: 'uploads/time_capsules/items',
                    maxWidth: 1600,
                    quality: 85
                );
            }
        }

        $item->update($data);
        return $item->fresh();
    }

    /**
     * Delete item.
     */
    public function deleteItem(int $id): bool
    {
        $item = TimeCapsuleItem::findOrFail($id);
        if ($item->media_path && File::exists(public_path($item->media_path))) {
            @unlink(public_path($item->media_path));
        }
        return $item->delete();
    }
}
