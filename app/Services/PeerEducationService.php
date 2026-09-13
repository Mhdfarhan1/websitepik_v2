<?php

namespace App\Services;

use App\Models\PeerEducation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PeerEducationService
{
    /**
     * Get all items sorted by order index.
     */
    public function getAllItems(): Collection
    {
        return PeerEducation::orderBy('order_index', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get paginated items.
     */
    public function getPaginatedItems(int $perPage = 10): LengthAwarePaginator
    {
        return PeerEducation::orderBy('order_index', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Create a new item.
     */
    public function createItem(array $data): PeerEducation
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = app(\App\Services\ImageCompressionService::class)->compressAndUpload(
                file: $data['image'],
                directory: 'peer_education',
                maxWidth: 1920,
                quality: 80,
                disk: 'public'
            );
        }

        return PeerEducation::create($data);
    }

    /**
     * Update an existing item.
     */
    public function updateItem(PeerEducation $peerEducation, array $data): PeerEducation
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($peerEducation->image) {
                app(\App\Services\ImageCompressionService::class)->delete($peerEducation->image, disk: 'public');
            }
            $data['image'] = app(\App\Services\ImageCompressionService::class)->compressAndUpload(
                file: $data['image'],
                directory: 'peer_education',
                maxWidth: 1920,
                quality: 80,
                disk: 'public'
            );
        }

        $peerEducation->update($data);

        return $peerEducation;
    }

    /**
     * Delete an item.
     */
    public function deleteItem(PeerEducation $peerEducation): bool
    {
        if ($peerEducation->image) {
            app(\App\Services\ImageCompressionService::class)->delete($peerEducation->image, disk: 'public');
        }

        return $peerEducation->delete();
    }

    /**
     * Get Edukasi page settings
     */
    public function getSettings(): array
    {
        $path = storage_path('app/edukasi_settings.json');
        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true);
        }
        return [
            'hero_title_1' => 'Edukasi',
            'hero_title_2' => 'Sebaya',
            'hero_desc' => 'Pendidik Sebaya (Peer Educator) adalah remaja yang memiliki komitmen dan kepedulian untuk memberikan edukasi serta informasi yang benar kepada teman sebaya. Kami hadir sebagai jembatan komunikasi yang relevan, akrab, dan tanpa sekat di lingkungan SMAN 1 Tasik Putri Puyu.',
            'hero_bg' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&q=80&w=1600',
        ];
    }

    /**
     * Update Edukasi page settings
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

        file_put_contents(storage_path('app/edukasi_settings.json'), json_encode($settings, JSON_PRETTY_PRINT));
    }
}
