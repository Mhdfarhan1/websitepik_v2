<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\AchievementService;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    protected AchievementService $achievementService;

    public function __construct(AchievementService $achievementService)
    {
        $this->achievementService = $achievementService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        $achievementList = $this->achievementService->getPaginatedAchievements($perPage, $search);
        return view('pages.dashboard.achievements.index', compact('achievementList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.achievements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'author' => 'nullable|string|max:100',
            'date' => 'nullable|date',
        ]);

        $data = $request->only(['title', 'description', 'image', 'author', 'date']);
        if (!$request->filled('author')) {
            $data['author'] = 'admin';
        }
        if (!$request->filled('date')) {
            $data['date'] = now()->toDateString();
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        if ($request->hasFile('photos')) {
            $data['photos'] = $request->file('photos');
        }

        $achievement = $this->achievementService->createAchievement($data);

        // Dispatch Centralized Web Push & Notification Center
        try {
            app(\App\Services\WebPushService::class)->send(
                title: 'Prestasi Baru 🏆',
                message: 'PIK-R REQUEST mengukir prestasi baru: "' . $achievement->title . '"',
                url: route('prestasi.show', $achievement->id),
                type: 'prestasi'
            );
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Notification error on achievement store: ' . $e->getMessage());
        }

        return redirect()->route('dashboard.achievements.index')->with('success', 'Prestasi dan dokumentasi foto berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $achievement = $this->achievementService->getAchievementById($id);
        return view('pages.dashboard.achievements.edit', compact('achievement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'delete_photo_ids' => 'nullable|array',
            'delete_photo_ids.*' => 'integer',
            'author' => 'nullable|string|max:100',
            'date' => 'nullable|date',
        ]);

        $data = $request->only(['title', 'description', 'author', 'date', 'delete_photo_ids']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        if ($request->hasFile('photos')) {
            $data['photos'] = $request->file('photos');
        }

        $this->achievementService->updateAchievement($id, $data);

        return redirect()->route('dashboard.achievements.index')->with('success', 'Prestasi dan dokumentasi foto berhasil diperbarui!');
    }

    /**
     * Delete an individual gallery photo via AJAX or form.
     */
    public function deletePhoto($achievementId, $photoId)
    {
        $this->achievementService->deletePhoto($photoId);
        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Foto berhasil dihapus']);
        }
        return back()->with('success', 'Foto dokumentasi berhasil dihapus!');
    }

    /**
     * Show settings for Prestasi Hero Banner.
     */
    public function settings()
    {
        $settings = $this->achievementService->getSettings();
        return view('pages.dashboard.achievements.settings', compact('settings'));
    }

    /**
     * Update settings for Prestasi Hero Banner.
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'hero_tag' => 'nullable|string|max:100',
            'hero_title_1' => 'nullable|string|max:100',
            'hero_title_2' => 'nullable|string|max:100',
            'hero_desc' => 'nullable|string',
            'hero_bg' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
            'hero_bg_color' => 'nullable|string|max:30',
            'section_title_1' => 'nullable|string|max:100',
            'section_title_2' => 'nullable|string|max:100',
        ]);

        $data = $request->all();
        if ($request->hasFile('hero_bg')) {
            $data['hero_bg'] = $request->file('hero_bg');
        }

        $this->achievementService->updateSettings($data);

        return back()->with('success', 'Pengaturan Banner Prestasi berhasil disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->achievementService->deleteAchievement($id);
        return redirect()->route('dashboard.achievements.index')->with('success', 'Prestasi dan semua dokumentasi fotonya berhasil dihapus!');
    }
}
