<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\TributeService;
use Illuminate\Http\Request;

class TributeController extends Controller
{
    protected TributeService $tributeService;

    public function __construct(TributeService $tributeService)
    {
        $this->tributeService = $tributeService;
    }

    /**
     * Show tribute management page in dashboard.
     */
    public function index(Request $request)
    {
        $editions = $this->tributeService->getAllEditions(false);
        
        // Selected edition to edit (default to featured or first)
        $selectedId = $request->query('edition_id');
        if ($selectedId) {
            $selectedEdition = $editions->firstWhere('id', (int)$selectedId) ?? $editions->first();
        } else {
            $selectedEdition = $editions->firstWhere('is_featured', true) ?? $editions->first();
        }

        return view('pages.dashboard.tributes.index', compact('editions', 'selectedEdition'));
    }

    /**
     * Store new edition (e.g. next year's Duta GenRe).
     */
    public function storeEdition(Request $request)
    {
        $request->validate([
            'period' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'badge_title' => 'nullable|string|max:255',
            'appreciation_quote' => 'nullable|string',
            'story_title' => 'nullable|string|max:255',
            'story_content' => 'nullable|string',
            'poster_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
            'school_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'institution_name' => 'nullable|string|max:255',
            'institution_subtext' => 'nullable|string|max:255',
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a,aac|max:20480',
            'audio_title' => 'nullable|string|max:255',
            'audio_artist' => 'nullable|string|max:255',
            'is_featured' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'period', 'title', 'subtitle', 'badge_title', 'appreciation_quote',
            'story_title', 'story_content',
            'institution_name', 'institution_subtext', 'audio_title', 'audio_artist'
        ]);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = true;

        $edition = $this->tributeService->storeEdition(
            $data, 
            $request->file('poster_image'),
            $request->file('school_logo'),
            $request->file('audio_file')
        );

        // Dispatch Centralized Web Push & Notification Center
        try {
            app(\App\Services\WebPushService::class)->send(
                title: 'Jejak Bakti Baru 👑',
                message: 'Rekam Jejak Duta GenRe telah diperbarui: "' . $edition->title . ' (' . $edition->period . ')"',
                url: url('/profil/jejak-bakti?periode=' . urlencode($edition->period)),
                type: 'jejak_bakti'
            );
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Notification error on tribute store: ' . $e->getMessage());
        }

        return redirect()->route('dashboard.tributes.index', ['edition_id' => $edition->id])
            ->with('success', 'Edisi Penghargaan Periode ' . $edition->period . ' berhasil ditambahkan!');
    }

    /**
     * Update edition.
     */
    public function updateEdition(Request $request, $id)
    {
        $request->validate([
            'period' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'badge_title' => 'nullable|string|max:255',
            'appreciation_quote' => 'nullable|string',
            'story_title' => 'nullable|string|max:255',
            'story_content' => 'nullable|string',
            'poster_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
            'school_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'institution_name' => 'nullable|string|max:255',
            'institution_subtext' => 'nullable|string|max:255',
            'remove_school_logo' => 'nullable|boolean',
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a,aac|max:20480',
            'audio_title' => 'nullable|string|max:255',
            'audio_artist' => 'nullable|string|max:255',
            'remove_audio' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'period', 'title', 'subtitle', 'badge_title', 'appreciation_quote',
            'story_title', 'story_content',
            'institution_name', 'institution_subtext', 'audio_title', 'audio_artist'
        ]);
        $data['remove_school_logo'] = $request->boolean('remove_school_logo');
        $data['remove_audio'] = $request->boolean('remove_audio');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active', true);

        $edition = $this->tributeService->updateEdition(
            (int)$id, 
            $data, 
            $request->file('poster_image'),
            $request->file('school_logo'),
            $request->file('audio_file')
        );

        return redirect()->route('dashboard.tributes.index', ['edition_id' => $edition->id])
            ->with('success', 'Pengaturan Periode ' . $edition->period . ' berhasil diperbarui!');
    }

    /**
     * Set edition as primary featured.
     */
    public function setFeatured($id)
    {
        $this->tributeService->setFeatured((int)$id);
        return redirect()->route('dashboard.tributes.index', ['edition_id' => $id])
            ->with('success', 'Periode ini berhasil dijadikan sorotan utama di Halaman Beranda!');
    }

    /**
     * Delete edition.
     */
    public function destroyEdition($id)
    {
        $this->tributeService->deleteEdition((int)$id);
        return redirect()->route('dashboard.tributes.index')
            ->with('success', 'Edisi penghargaan berhasil dihapus!');
    }

    /**
     * Store new tribute figure into edition.
     */
    public function storeFigure(Request $request)
    {
        $request->validate([
            'tribute_edition_id' => 'required|exists:tribute_editions,id',
            'name' => 'required|string|max:255',
            'honor_title' => 'required|string|max:255',
            'period' => 'nullable|string|max:100',
            'badge_color' => 'required|string|in:amber,sky,emerald,rose,purple',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
            'quote' => 'nullable|string',
            'contribution' => 'nullable|string',
            'instagram' => 'nullable|string|max:255',
            'order_index' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $editionId = (int)$request->tribute_edition_id;
        $data = $request->only(['name', 'honor_title', 'period', 'badge_color', 'quote', 'contribution', 'instagram', 'order_index']);
        $data['is_active'] = $request->boolean('is_active', true);

        $this->tributeService->storeFigure($editionId, $data, $request->file('photo'));

        return redirect()->route('dashboard.tributes.index', ['edition_id' => $editionId])
            ->with('success', 'Data Duta/Tokoh berhasil ditambahkan ke periode ini!');
    }

    /**
     * Update tribute figure.
     */
    public function updateFigure(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'honor_title' => 'required|string|max:255',
            'period' => 'nullable|string|max:100',
            'badge_color' => 'required|string|in:amber,sky,emerald,rose,purple',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
            'quote' => 'nullable|string',
            'contribution' => 'nullable|string',
            'instagram' => 'nullable|string|max:255',
            'order_index' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only(['name', 'honor_title', 'period', 'badge_color', 'quote', 'contribution', 'instagram', 'order_index']);
        $data['is_active'] = $request->boolean('is_active', true);

        $figure = $this->tributeService->updateFigure((int)$id, $data, $request->file('photo'));

        return redirect()->route('dashboard.tributes.index', ['edition_id' => $figure->tribute_edition_id])
            ->with('success', 'Data Duta/Tokoh berhasil diperbarui!');
    }

    /**
     * Delete tribute figure.
     */
    public function destroyFigure($id)
    {
        $figure = \App\Models\TributeFigure::findOrFail($id);
        $editionId = $figure->tribute_edition_id;
        $this->tributeService->deleteFigure((int)$id);

        return redirect()->route('dashboard.tributes.index', ['edition_id' => $editionId])
            ->with('success', 'Data Duta/Tokoh berhasil dihapus!');
    }

    /**
     * Store memory photo.
     */
    public function storeMemory(Request $request)
    {
        $request->validate([
            'tribute_edition_id' => 'required|exists:tribute_editions,id',
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:15360',
            'caption' => 'nullable|string',
            'event_date' => 'nullable|date',
            'order_index' => 'nullable|integer',
        ]);

        $editionId = (int)$request->tribute_edition_id;
        $data = $request->only(['title', 'caption', 'event_date', 'order_index']);
        $this->tributeService->storeMemory($editionId, $data, $request->file('image'));

        return redirect()->route('dashboard.tributes.index', ['edition_id' => $editionId])
            ->with('success', 'Foto kenangan berhasil ditambahkan!');
    }

    /**
     * Delete memory photo.
     */
    public function destroyMemory($id)
    {
        $memory = \App\Models\TributeMemory::findOrFail($id);
        $editionId = $memory->tribute_edition_id;
        $this->tributeService->deleteMemory((int)$id);

        return redirect()->route('dashboard.tributes.index', ['edition_id' => $editionId])
            ->with('success', 'Foto kenangan berhasil dihapus!');
    }
}
