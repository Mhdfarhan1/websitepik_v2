<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\TimeCapsuleService;
use Illuminate\Http\Request;

class TimeCapsuleController extends Controller
{
    protected TimeCapsuleService $timeCapsuleService;

    public function __construct(TimeCapsuleService $timeCapsuleService)
    {
        $this->timeCapsuleService = $timeCapsuleService;
    }

    /**
     * Display Time Capsules management dashboard.
     */
    public function index(Request $request)
    {
        $setting = $this->timeCapsuleService->getSetting();
        $capsules = $this->timeCapsuleService->getAllCapsules(false);

        $selectedCapsuleId = $request->query('capsule_id');
        $selectedCapsule = null;

        if ($selectedCapsuleId) {
            $selectedCapsule = $capsules->firstWhere('id', (int) $selectedCapsuleId);
        }

        if (!$selectedCapsule) {
            $selectedCapsule = $capsules->firstWhere('is_featured', true) ?? $capsules->first();
        }

        // If selected capsule exists, ensure related items are loaded
        if ($selectedCapsule) {
            $selectedCapsule = $this->timeCapsuleService->getCapsuleById($selectedCapsule->id);
        }

        return view('pages.dashboard.time-capsules.index', compact('setting', 'capsules', 'selectedCapsule'));
    }

    /**
     * Update page settings & ambient audio.
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'badge_title' => 'required|string|max:255',
            'page_title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'audio_title' => 'nullable|string|max:255',
            'audio_artist' => 'nullable|string|max:255',
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a,aac|max:25600',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
            'is_audio_active' => 'nullable|boolean',
            'remove_audio' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'badge_title', 'page_title', 'subtitle', 'audio_title', 'audio_artist'
        ]);
        $data['is_audio_active'] = $request->boolean('is_audio_active');
        if ($request->boolean('remove_audio')) {
            $data['remove_audio'] = true;
        }

        $this->timeCapsuleService->updateSetting(
            $data,
            $request->file('audio_file'),
            $request->file('banner_image')
        );

        return back()->with('success', 'Pengaturan Kotak Waktu PIK-R berhasil diperbarui!');
    }

    /**
     * Store new time capsule.
     */
    public function storeCapsule(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'creator_generation' => 'required|string|max:255',
            'created_date' => 'required|date',
            'unlock_date' => 'required|date',
            'seal_message' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'theme_color' => 'nullable|string|in:amber,sky,emerald,purple,rose',
            'order_index' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'title', 'creator_generation', 'created_date', 'unlock_date',
            'seal_message', 'theme_color', 'order_index'
        ]);
        $data['theme_color'] = $data['theme_color'] ?? 'amber';
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active', true);

        $capsule = $this->timeCapsuleService->storeCapsule($data, $request->file('cover_image'));

        return redirect()->route('dashboard.time-capsules.index', ['capsule_id' => $capsule->id])
            ->with('success', "Kotak Waktu '{$capsule->title}' berhasil dibuat!");
    }

    /**
     * Update existing time capsule.
     */
    public function updateCapsule(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'creator_generation' => 'required|string|max:255',
            'created_date' => 'required|date',
            'unlock_date' => 'required|date',
            'seal_message' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'theme_color' => 'nullable|string|in:amber,sky,emerald,purple,rose',
            'order_index' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'title', 'creator_generation', 'created_date', 'unlock_date',
            'seal_message', 'theme_color', 'order_index'
        ]);
        $data['theme_color'] = $data['theme_color'] ?? 'amber';
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active', true);

        $capsule = $this->timeCapsuleService->updateCapsule((int) $id, $data, $request->file('cover_image'));

        return redirect()->route('dashboard.time-capsules.index', ['capsule_id' => $capsule->id])
            ->with('success', "Kotak Waktu '{$capsule->title}' berhasil diperbarui!");
    }

    /**
     * Delete a time capsule.
     */
    public function destroyCapsule($id)
    {
        $this->timeCapsuleService->deleteCapsule((int) $id);
        return redirect()->route('dashboard.time-capsules.index')
            ->with('success', 'Kotak Waktu dan seluruh arsip isinya berhasil dihapus.');
    }

    /**
     * Set a capsule as featured.
     */
    public function setFeatured($id)
    {
        $this->timeCapsuleService->setFeatured((int) $id);
        return back()->with('success', 'Kotak Waktu utama berhasil diubah!');
    }

    /**
     * Store item inside capsule.
     */
    public function storeItem(Request $request, $capsuleId)
    {
        $request->validate([
            'type' => 'required|string|in:letter,story,photo,video',
            'title' => 'required|string|max:255',
            'author_name' => 'nullable|string|max:255',
            'author_role' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'media_file' => 'nullable|file|max:51200', // images or video clips up to 50MB
            'external_url' => 'nullable|string|max:500',
            'order_index' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'type', 'title', 'author_name', 'author_role',
            'content', 'external_url', 'order_index'
        ]);
        $data['is_active'] = $request->boolean('is_active', true);

        $this->timeCapsuleService->storeItem((int) $capsuleId, $data, $request->file('media_file'));

        $typeLabel = match($data['type']) {
            'letter' => 'Surat / Pesan',
            'story' => 'Cerita Kenangan',
            'photo' => 'Foto Arsip',
            'video' => 'Video Dokumentasi',
            default => 'Konten'
        };

        return back()->with('success', "{$typeLabel} berhasil ditambahkan ke Kotak Waktu!");
    }

    /**
     * Update item inside capsule.
     */
    public function updateItem(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string|in:letter,story,photo,video',
            'title' => 'required|string|max:255',
            'author_name' => 'nullable|string|max:255',
            'author_role' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'media_file' => 'nullable|file|max:51200',
            'external_url' => 'nullable|string|max:500',
            'order_index' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'type', 'title', 'author_name', 'author_role',
            'content', 'external_url', 'order_index'
        ]);
        $data['is_active'] = $request->boolean('is_active', true);

        $this->timeCapsuleService->updateItem((int) $id, $data, $request->file('media_file'));

        return back()->with('success', 'Konten Kotak Waktu berhasil diperbarui!');
    }

    /**
     * Destroy item.
     */
    public function destroyItem($id)
    {
        $this->timeCapsuleService->deleteItem((int) $id);
        return back()->with('success', 'Konten berhasil dihapus dari Kotak Waktu.');
    }
}
