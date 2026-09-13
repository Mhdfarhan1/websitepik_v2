<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\AchievementImage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class AchievementService
{
    /**
     * Get settings for Prestasi page (Hero banner, titles, background, colors).
     */
    public function getSettings(): array
    {
        $path = storage_path('app/prestasi_settings.json');
        if (file_exists($path)) {
            $data = json_decode(file_get_contents($path), true);
            if (is_array($data)) {
                return array_merge($this->defaultSettings(), $data);
            }
        }
        return $this->defaultSettings();
    }

    /**
     * Default settings for Prestasi hero banner.
     */
    private function defaultSettings(): array
    {
        return [
            'hero_tag' => 'Jejak Apresiasi & Prestasi',
            'hero_title_1' => 'Capaian &',
            'hero_title_2' => 'Prestasi',
            'hero_desc' => 'PIK-R REQUEST SMAN 1 Tasik Putri Puyu terus berkomitmen untuk memberikan dampak positif. Berbagai penghargaan dan apresiasi telah kami raih sebagai wujud dedikasi kami dalam mengedukasi generasi berencana.',
            'hero_bg' => 'https://images.unsplash.com/photo-1531545517246-167e1fd8b76c?auto=format&fit=crop&q=80&w=1600',
            'hero_bg_color' => '#1e3a5f',
            'section_title_1' => 'Dedikasi',
            'section_title_2' => 'Tanpa Henti',
            'cta_title' => 'Ingin berkonsultasi atau bergabung dengan PIK-R REQUEST?',
            'cta_desc' => 'Kami selalu terbuka untuk mendengarkan dan tumbuh bersama setiap remaja.',
        ];
    }

    /**
     * Update settings for Prestasi page.
     */
    public function updateSettings(array $data): void
    {
        $settings = $this->getSettings();

        $settings['hero_tag'] = $data['hero_tag'] ?? $settings['hero_tag'];
        $settings['hero_title_1'] = $data['hero_title_1'] ?? $settings['hero_title_1'];
        $settings['hero_title_2'] = $data['hero_title_2'] ?? $settings['hero_title_2'];
        $settings['hero_desc'] = $data['hero_desc'] ?? $settings['hero_desc'];
        $settings['hero_bg_color'] = $data['hero_bg_color'] ?? $settings['hero_bg_color'];
        $settings['section_title_1'] = $data['section_title_1'] ?? $settings['section_title_1'];
        $settings['section_title_2'] = $data['section_title_2'] ?? $settings['section_title_2'];
        $settings['cta_title'] = $data['cta_title'] ?? $settings['cta_title'];
        $settings['cta_desc'] = $data['cta_desc'] ?? $settings['cta_desc'];

        if (isset($data['hero_bg']) && $data['hero_bg'] instanceof UploadedFile) {
            // Delete old custom hero_bg if not default unsplash
            if (!empty($settings['hero_bg']) && !str_starts_with($settings['hero_bg'], 'http')) {
                $this->deleteImage($settings['hero_bg']);
            }
            $settings['hero_bg'] = $this->uploadImage($data['hero_bg']);
        }

        file_put_contents(storage_path('app/prestasi_settings.json'), json_encode($settings, JSON_PRETTY_PRINT));
    }

    /**
     * Get all achievements with images ordered by date.
     */
    public function getAllAchievements()
    {
        return Achievement::with('images')->orderBy('date', 'desc')->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get paginated achievements with images.
     */
    public function getPaginatedAchievements(int $perPage = 10, ?string $search = null)
    {
        return Achievement::with('images')
            ->when($search, function($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%");
            })
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Get latest achievements.
     */
    public function getLatestAchievements(int $limit = 3)
    {
        return Achievement::with('images')->orderBy('date', 'desc')->orderBy('created_at', 'desc')->take($limit)->get();
    }

    /**
     * Get a single achievement by ID.
     */
    public function getAchievementById(int $id)
    {
        return Achievement::with('images')->findOrFail($id);
    }

    /**
     * Create a new achievement with primary image & optional gallery photos.
     */
    public function createAchievement(array $data)
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->uploadImage($data['image']);
        }

        $photos = $data['photos'] ?? [];
        unset($data['photos']);

        $achievement = Achievement::create($data);

        // Upload and compress multiple documentation photos
        if (!empty($photos) && is_array($photos)) {
            $this->saveMultiplePhotos($achievement, $photos);
        }

        return $achievement;
    }

    /**
     * Update an existing achievement.
     */
    public function updateAchievement(int $id, array $data)
    {
        $achievement = $this->getAchievementById($id);

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $this->deleteImage($achievement->image);
            $data['image'] = $this->uploadImage($data['image']);
        }

        $photos = $data['photos'] ?? [];
        $deletePhotoIds = $data['delete_photo_ids'] ?? [];
        unset($data['photos'], $data['delete_photo_ids']);

        // Delete specified photos
        if (!empty($deletePhotoIds) && is_array($deletePhotoIds)) {
            foreach ($deletePhotoIds as $photoId) {
                $this->deletePhoto((int) $photoId);
            }
        }

        // Upload and append additional documentation photos
        if (!empty($photos) && is_array($photos)) {
            $this->saveMultiplePhotos($achievement, $photos);
        }

        $achievement->update($data);
        return $achievement;
    }

    /**
     * Save multiple photos for an achievement with auto-compression.
     */
    public function saveMultiplePhotos(Achievement $achievement, array $photos): void
    {
        $currentMaxOrder = $achievement->images()->max('order_index') ?? 0;

        foreach ($photos as $photo) {
            if ($photo instanceof UploadedFile) {
                $path = $this->uploadImage($photo);
                $achievement->images()->create([
                    'image_path' => $path,
                    'order_index' => ++$currentMaxOrder,
                ]);
            }
        }
    }

    /**
     * Delete a single gallery photo.
     */
    public function deletePhoto(int $photoId): bool
    {
        $photo = AchievementImage::find($photoId);
        if ($photo) {
            $this->deleteImage($photo->image_path);
            return $photo->delete();
        }
        return false;
    }

    /**
     * Delete an achievement and all its associated photos.
     */
    public function deleteAchievement(int $id)
    {
        $achievement = $this->getAchievementById($id);

        // Delete primary cover image
        $this->deleteImage($achievement->image);

        // Delete all gallery photos
        foreach ($achievement->images as $photo) {
            $this->deleteImage($photo->image_path);
        }

        return $achievement->delete();
    }

    /**
     * Upload and automatically compress achievement image to WebP.
     */
    private function uploadImage(UploadedFile $file): string
    {
        return app(ImageCompressionService::class)->compressAndUpload(
            file: $file,
            directory: 'uploads/achievements',
            maxWidth: 1920,
            quality: 80
        );
    }

    /**
     * Delete image file.
     */
    private function deleteImage(?string $path): void
    {
        app(ImageCompressionService::class)->delete($path);
    }
}
