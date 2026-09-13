<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        $newsList = $this->newsService->getPaginatedNews($perPage, $search);
        return view('pages.dashboard.news.index', compact('newsList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->only(['title', 'content', 'image', 'published_at']);
        if ($request->filled('published_at')) {
            $data['published_at'] = $request->input('published_at');
        } else {
            $data['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $news = $this->newsService->createNews($data);

        \App\Services\ActivityLogService::log(
            'created',
            "Membuat berita: {$data['title']}",
            'News',
            $news->id ?? null
        );

        return redirect()->route('dashboard.news.index')->with('success', 'Berita berhasil diterbitkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $news = $this->newsService->getNewsById($id);
        return view('pages.dashboard.news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->only(['title', 'content', 'published_at']);
        if ($request->filled('published_at')) {
            $data['published_at'] = $request->input('published_at');
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $news = $this->newsService->updateNews($id, $data);

        \App\Services\ActivityLogService::log(
            'updated',
            "Memperbarui berita ID: {$id}",
            'News',
            $id
        );

        return redirect()->route('dashboard.news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $news = $this->newsService->getNewsById($id);
        $title = $news ? $news->title : "ID {$id}";
        
        $this->newsService->deleteNews($id);

        \App\Services\ActivityLogService::log(
            'deleted',
            "Menghapus berita: {$title}",
            'News',
            $id
        );

        return redirect()->route('dashboard.news.index')->with('success', 'Berita berhasil dihapus!');
    }
}
