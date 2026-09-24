<?php

namespace App\Services;

use App\Models\TributeEdition;
use App\Models\TributeFigure;
use App\Models\TributeMemory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TributeService
{
    protected ImageCompressionService $compressionService;

    public function __construct(ImageCompressionService $compressionService)
    {
        $this->compressionService = $compressionService;
    }

    /**
     * Get all tribute editions with their figures and memories.
     */
    public function getAllEditions(bool $onlyActive = false)
    {
        $query = TributeEdition::with(['figures', 'memories'])
            ->orderBy('is_featured', 'desc')
            ->orderBy('order_index', 'asc')
            ->orderBy('id', 'desc');

        if ($onlyActive) {
            $query->where('is_active', true);
        }

        return $query->get();
    }

    /**
     * Get the featured edition for the homepage.
     */
    public function getFeaturedEdition(): ?TributeEdition
    {
        $featured = TributeEdition::with(['figures', 'memories'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->first();

        if (!$featured) {
            $featured = TributeEdition::with(['figures', 'memories'])
                ->where('is_active', true)
                ->orderBy('id', 'desc')
                ->first();
        }

        return $featured;
    }

    /**
     * Get single edition by ID.
     */
    public function getEditionById(int $id): TributeEdition
    {
        return TributeEdition::with(['figures', 'memories'])->findOrFail($id);
    }

    /**
     * Store new edition (e.g. for next year).
     */
    public function storeEdition(array $data, ?UploadedFile $posterFile = null, ?UploadedFile $schoolLogoFile = null, ?UploadedFile $audioFile = null): TributeEdition
    {
        if ($posterFile) {
            $data['poster_image'] = $this->compressionService->compressAndUpload(
                file: $posterFile,
                directory: 'uploads/tributes',
                maxWidth: 1600,
                quality: 85
            );
        }

        if ($schoolLogoFile) {
            $data['school_logo'] = $this->compressionService->compressAndUpload(
                file: $schoolLogoFile,
                directory: 'uploads/tributes',
                maxWidth: 600,
                quality: 90
            );
        }

        if ($audioFile) {
            $dir = public_path('uploads/tributes/audio');
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $filename = 'audio_' . time() . '_' . Str::random(8) . '.' . $audioFile->getClientOriginalExtension();
            $audioFile->move($dir, $filename);
            $data['audio_file'] = 'uploads/tributes/audio/' . $filename;
        }

        if (!empty($data['is_featured'])) {
            // Unset other featured editions so only one is primary featured
            TributeEdition::query()->update(['is_featured' => false]);
            $data['is_featured'] = true;
        }

        if (!isset($data['order_index'])) {
            $data['order_index'] = (TributeEdition::max('order_index') ?? 0) + 1;
        }

        return TributeEdition::create($data);
    }

    /**
     * Update an existing edition.
     */
    public function updateEdition(int $id, array $data, ?UploadedFile $posterFile = null, ?UploadedFile $schoolLogoFile = null, ?UploadedFile $audioFile = null): TributeEdition
    {
        $edition = TributeEdition::findOrFail($id);

        if ($posterFile) {
            if ($edition->poster_image && File::exists(public_path($edition->poster_image)) && !str_contains($edition->poster_image, 'poster_duta_genre.jpg')) {
                @unlink(public_path($edition->poster_image));
            }

            $data['poster_image'] = $this->compressionService->compressAndUpload(
                file: $posterFile,
                directory: 'uploads/tributes',
                maxWidth: 1600,
                quality: 85
            );
        }

        if (!empty($data['remove_school_logo'])) {
            if ($edition->school_logo && File::exists(public_path($edition->school_logo))) {
                @unlink(public_path($edition->school_logo));
            }
            $data['school_logo'] = null;
            unset($data['remove_school_logo']);
        } elseif ($schoolLogoFile) {
            if ($edition->school_logo && File::exists(public_path($edition->school_logo))) {
                @unlink(public_path($edition->school_logo));
            }

            $data['school_logo'] = $this->compressionService->compressAndUpload(
                file: $schoolLogoFile,
                directory: 'uploads/tributes',
                maxWidth: 600,
                quality: 90
            );
        }

        if (!empty($data['remove_audio'])) {
            if ($edition->audio_file && File::exists(public_path($edition->audio_file))) {
                @unlink(public_path($edition->audio_file));
            }
            $data['audio_file'] = null;
            $data['audio_title'] = null;
            $data['audio_artist'] = null;
            unset($data['remove_audio']);
        } elseif ($audioFile) {
            if ($edition->audio_file && File::exists(public_path($edition->audio_file))) {
                @unlink(public_path($edition->audio_file));
            }
            $dir = public_path('uploads/tributes/audio');
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $filename = 'audio_' . time() . '_' . Str::random(8) . '.' . $audioFile->getClientOriginalExtension();
            $audioFile->move($dir, $filename);
            $data['audio_file'] = 'uploads/tributes/audio/' . $filename;
        }

        if (!empty($data['is_featured'])) {
            TributeEdition::where('id', '!=', $id)->update(['is_featured' => false]);
            $data['is_featured'] = true;
        }

        $edition->update($data);
        return $edition;
    }

    /**
     * Set specific edition as the featured one.
     */
    public function setFeatured(int $id): bool
    {
        TributeEdition::query()->update(['is_featured' => false]);
        $edition = TributeEdition::findOrFail($id);
        $edition->update(['is_featured' => true]);
        return true;
    }

    /**
     * Delete an edition along with its assets.
     */
    public function deleteEdition(int $id): bool
    {
        $edition = TributeEdition::with(['figures', 'memories'])->findOrFail($id);

        // Remove poster
        if ($edition->poster_image && File::exists(public_path($edition->poster_image)) && !str_contains($edition->poster_image, 'poster_duta_genre.jpg')) {
            @unlink(public_path($edition->poster_image));
        }

        // Remove school logo
        if ($edition->school_logo && File::exists(public_path($edition->school_logo))) {
            @unlink(public_path($edition->school_logo));
        }

        // Remove audio file
        if ($edition->audio_file && File::exists(public_path($edition->audio_file))) {
            @unlink(public_path($edition->audio_file));
        }

        // Remove figure photos
        foreach ($edition->figures as $fig) {
            if ($fig->photo && File::exists(public_path($fig->photo))) {
                @unlink(public_path($fig->photo));
            }
        }

        // Remove memory photos
        foreach ($edition->memories as $mem) {
            if ($mem->image && File::exists(public_path($mem->image))) {
                @unlink(public_path($mem->image));
            }
        }

        return $edition->delete();
    }

    /**
     * Store new figure in an edition.
     */
    public function storeFigure(int $editionId, array $data, ?UploadedFile $photoFile = null): TributeFigure
    {
        $data['tribute_edition_id'] = $editionId;

        if ($photoFile) {
            $data['photo'] = $this->compressionService->compressAndUpload(
                file: $photoFile,
                directory: 'uploads/tributes/figures',
                maxWidth: 800,
                quality: 85
            );
        }

        if (!isset($data['order_index'])) {
            $data['order_index'] = (TributeFigure::where('tribute_edition_id', $editionId)->max('order_index') ?? 0) + 1;
        }

        return TributeFigure::create($data);
    }

    /**
     * Update figure.
     */
    public function updateFigure(int $id, array $data, ?UploadedFile $photoFile = null): TributeFigure
    {
        $figure = TributeFigure::findOrFail($id);

        if ($photoFile) {
            if ($figure->photo && File::exists(public_path($figure->photo))) {
                @unlink(public_path($figure->photo));
            }

            $data['photo'] = $this->compressionService->compressAndUpload(
                file: $photoFile,
                directory: 'uploads/tributes/figures',
                maxWidth: 800,
                quality: 85
            );
        }

        $figure->update($data);
        return $figure;
    }

    /**
     * Delete figure.
     */
    public function deleteFigure(int $id): bool
    {
        $figure = TributeFigure::findOrFail($id);
        if ($figure->photo && File::exists(public_path($figure->photo))) {
            @unlink(public_path($figure->photo));
        }
        return $figure->delete();
    }

    /**
     * Store memory photo in an edition.
     */
    public function storeMemory(int $editionId, array $data, UploadedFile $imageFile): TributeMemory
    {
        $data['tribute_edition_id'] = $editionId;

        $data['image'] = $this->compressionService->compressAndUpload(
            file: $imageFile,
            directory: 'uploads/tributes/memories',
            maxWidth: 1200,
            quality: 80
        );

        if (!isset($data['order_index'])) {
            $data['order_index'] = (TributeMemory::where('tribute_edition_id', $editionId)->max('order_index') ?? 0) + 1;
        }

        return TributeMemory::create($data);
    }

    /**
     * Delete memory photo.
     */
    public function deleteMemory(int $id): bool
    {
        $memory = TributeMemory::findOrFail($id);
        if ($memory->image && File::exists(public_path($memory->image))) {
            @unlink(public_path($memory->image));
        }
        return $memory->delete();
    }

    /**
     * Increment appreciation count.
     */
    public function incrementAppreciation(?int $editionId = null): int
    {
        if ($editionId) {
            $edition = TributeEdition::find($editionId);
        } else {
            $edition = $this->getFeaturedEdition();
        }

        if ($edition) {
            $edition->increment('appreciation_count');
            return $edition->appreciation_count;
        }

        return 0;
    }
}
