<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PeerEducation;
use App\Services\PeerEducationService;
use Illuminate\Http\Request;

class PeerEducationController extends Controller
{
    protected $peerEducationService;

    public function __construct(PeerEducationService $peerEducationService)
    {
        $this->peerEducationService = $peerEducationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peerEducations = $this->peerEducationService->getPaginatedItems(10);
        return view('pages.dashboard.peer_educations.index', compact('peerEducations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.peer_educations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'desc2' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'order_index' => 'nullable|integer',
            'participant_count' => 'required|integer|min:0',
        ]);

        $this->peerEducationService->createItem($validated);

        return redirect()->route('dashboard.peer-educations.index')->with('success', 'Edukasi Sebaya berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PeerEducation $peerEducation)
    {
        return view('pages.dashboard.peer_educations.edit', compact('peerEducation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PeerEducation $peerEducation)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'desc2' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'order_index' => 'nullable|integer',
            'participant_count' => 'required|integer|min:0',
        ]);

        $this->peerEducationService->updateItem($peerEducation, $validated);

        return redirect()->route('dashboard.peer-educations.index')->with('success', 'Edukasi Sebaya berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PeerEducation $peerEducation)
    {
        $this->peerEducationService->deleteItem($peerEducation);

        return redirect()->route('dashboard.peer-educations.index')->with('success', 'Edukasi Sebaya berhasil dihapus.');
    }

    /**
     * Show the settings form for Edukasi page
     */
    public function settings()
    {
        $settings = $this->peerEducationService->getSettings();
        return view('pages.dashboard.peer_educations.settings', compact('settings'));
    }

    /**
     * Update settings for Edukasi page
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'hero_title_1' => 'nullable|string|max:255',
            'hero_title_2' => 'nullable|string|max:255',
            'hero_desc' => 'nullable|string',
            'hero_bg' => 'nullable|image|max:10240',
        ]);

        $this->peerEducationService->updateSettings($validated);

        return redirect()->route('dashboard.peer-educations.settings')->with('success', 'Pengaturan Halaman Edukasi Sebaya berhasil diperbarui.');
    }
}
