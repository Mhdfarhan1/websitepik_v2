<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\GalleryService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    protected $galleryService;

    public function __construct(GalleryService $galleryService)
    {
        $this->galleryService = $galleryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        $galleryList = $this->galleryService->getPaginatedGallery($perPage, $search);
        return view('pages.dashboard.gallery.index', compact('galleryList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'type' => 'required|string|in:image,video',
            'order_index' => 'nullable|integer',
        ]);

        $data = $request->only(['title', 'image', 'type', 'order_index']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $this->galleryService->createGallery($data);

        return redirect()->route('dashboard.gallery.index')->with('success', 'Item galeri berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $gallery = $this->galleryService->getGalleryById($id);
        return view('pages.dashboard.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'type' => 'required|string|in:image,video',
            'order_index' => 'nullable|integer',
        ]);

        $data = $request->only(['title', 'type', 'order_index']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $this->galleryService->updateGallery($id, $data);

        return redirect()->route('dashboard.gallery.index')->with('success', 'Item galeri berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->galleryService->deleteGallery($id);
        return redirect()->route('dashboard.gallery.index')->with('success', 'Item galeri berhasil dihapus!');
    }
}
