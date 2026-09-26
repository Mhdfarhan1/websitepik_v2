<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\LeaderService;
use Illuminate\Http\Request;

class LeaderController extends Controller
{
    protected LeaderService $leaderService;

    public function __construct(LeaderService $leaderService)
    {
        $this->leaderService = $leaderService;
    }

    /**
     * Display leadership history management page.
     */
    public function index()
    {
        $setting = $this->leaderService->getSetting();
        $leaders = $this->leaderService->getAllLeaders(false);

        return view('pages.dashboard.leaders.index', compact('setting', 'leaders'));
    }

    /**
     * Update page settings & background audio.
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

        $this->leaderService->updateSetting(
            $data,
            $request->file('audio_file'),
            $request->file('banner_image')
        );

        return back()->with('success', 'Pengaturan halaman dan audio Jejak Nakhoda berhasil diperbarui!');
    }

    /**
     * Store new leader.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'period' => 'required|string|max:100',
            'generation' => 'nullable|string|max:100',
            'title_badge' => 'required|string|max:100',
            'status' => 'required|string|in:demisioner,aktif',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'quote' => 'nullable|string',
            'story' => 'nullable|string',
            'experience' => 'nullable|string',
            'hope' => 'nullable|string',
            'instagram' => 'nullable|string|max:100',
            'linkedin' => 'nullable|string|max:255',
            'order_index' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'name', 'period', 'generation', 'title_badge', 'status',
            'quote', 'story', 'experience', 'hope', 'instagram', 'linkedin', 'order_index'
        ]);
        $data['is_active'] = $request->boolean('is_active', true);

        $this->leaderService->storeLeader($data, $request->file('photo'));

        return back()->with('success', 'Data Ketua berhasil ditambahkan!');
    }

    /**
     * Update existing leader.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'period' => 'required|string|max:100',
            'generation' => 'nullable|string|max:100',
            'title_badge' => 'required|string|max:100',
            'status' => 'required|string|in:demisioner,aktif',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'quote' => 'nullable|string',
            'story' => 'nullable|string',
            'experience' => 'nullable|string',
            'hope' => 'nullable|string',
            'instagram' => 'nullable|string|max:100',
            'linkedin' => 'nullable|string|max:255',
            'order_index' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'remove_photo' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'name', 'period', 'generation', 'title_badge', 'status',
            'quote', 'story', 'experience', 'hope', 'instagram', 'linkedin', 'order_index'
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        if ($request->boolean('remove_photo')) {
            $data['remove_photo'] = true;
        }

        $this->leaderService->updateLeader($id, $data, $request->file('photo'));

        return back()->with('success', 'Data Ketua berhasil diperbarui!');
    }

    /**
     * Delete leader.
     */
    public function destroy($id)
    {
        $this->leaderService->deleteLeader($id);

        return back()->with('success', 'Data Ketua berhasil dihapus!');
    }

    /**
     * Reorder leaders.
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:leader_histories,id',
        ]);

        $this->leaderService->reorderLeaders($request->order);

        return response()->json(['success' => true]);
    }
}
