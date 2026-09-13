<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class NewsService
{
    /**
     * Get all news ordered by publication date.
     */
    public function getAllNews()
    {
        return News::orderBy('published_at', 'desc')->get();
    }

    /**
     * Get paginated news.
     */
    public function getPaginatedNews(int $perPage = 10, ?string $search = null)
    {
        return News::when($search, function($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
            })
            ->orderBy('published_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Get latest news.
     */
    public function getLatestNews(int $limit = 4)
    {
        return News::orderBy('published_at', 'desc')->take($limit)->get();
    }

    /**
     * Get a single news item by ID.
     */
    public function getNewsById(int $id)
    {
        return News::findOrFail($id);
    }

    /**
     * Get a single news item by slug.
     */
    public function getNewsBySlug(string $slug)
    {
        return News::where('slug', $slug)->firstOrFail();
    }

    /**
     * Create new post.
     */
    public function createNews(array $data)
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->uploadImage($data['image']);
        }

        return News::create($data);
    }

    /**
     * Update existing post.
     */
    public function updateNews(int $id, array $data)
    {
        $news = $this->getNewsById($id);

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            // Delete old image if it exists
            $this->deleteImage($news->image);
            $data['image'] = $this->uploadImage($data['image']);
        }

        $news->update($data);
        return $news;
    }

    /**
     * Delete a post.
     */
    public function deleteNews(int $id)
    {
        $news = $this->getNewsById($id);
        $this->deleteImage($news->image);
        return $news->delete();
    }

    /**
     * Upload and automatically compress news image to WebP.
     */
    private function uploadImage(UploadedFile $file): string
    {
        return app(ImageCompressionService::class)->compressAndUpload(
            file: $file,
            directory: 'uploads/news',
            maxWidth: 1920,
            quality: 80
        );
    }

    /**
     * Delete image from storage.
     */
    private function deleteImage(?string $path): void
    {
        app(ImageCompressionService::class)->delete($path);
    }
}
