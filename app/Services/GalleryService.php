<?php

namespace App\Services;

use App\Models\Gallery;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class GalleryService
{
    /**
     * Get all gallery items sorted by order_index and created date.
     */
    public function getAllGallery()
    {
        return Gallery::orderBy('order_index', 'asc')->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get paginated gallery items.
     */
    public function getPaginatedGallery(int $perPage = 12, ?string $search = null)
    {
        return Gallery::when($search, function($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->orderBy('order_index', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Get a single gallery item by ID.
     */
    public function getGalleryById(int $id)
    {
        return Gallery::findOrFail($id);
    }

    /**
     * Create a new gallery item.
     */
    public function createGallery(array $data)
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->uploadImage($data['image']);
        }

        return Gallery::create($data);
    }

    /**
     * Update an existing gallery item.
     */
    public function updateGallery(int $id, array $data)
    {
        $gallery = $this->getGalleryById($id);

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $this->deleteImage($gallery->image);
            $data['image'] = $this->uploadImage($data['image']);
        }

        $gallery->update($data);
        return $gallery;
    }

    /**
     * Delete a gallery item.
     */
    public function deleteGallery(int $id)
    {
        $gallery = $this->getGalleryById($id);
        $this->deleteImage($gallery->image);
        return $gallery->delete();
    }

    /**
     * Upload and automatically compress gallery image to WebP.
     */
    private function uploadImage(UploadedFile $file): string
    {
        return app(ImageCompressionService::class)->compressAndUpload(
            file: $file,
            directory: 'uploads/gallery',
            maxWidth: 1920,
            quality: 80
        );
    }

    /**
     * Delete gallery image from disk.
     */
    private function deleteImage(?string $path): void
    {
        app(ImageCompressionService::class)->delete($path);
    }
}
