<?php

namespace App\Services;

use App\Models\OrganizationStructure;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class OrganizationStructureService
{
    /**
     * Get settings for Organization Structure page (Periode, Subtitle, Bagan Image, Bagan PDF).
     */
    public function getSettings(): array
    {
        $path = storage_path('app/struktur_settings.json');
        if (file_exists($path)) {
            $data = json_decode(file_get_contents($path), true);
            if (is_array($data)) {
                return array_merge($this->defaultSettings(), $data);
            }
        }
        return $this->defaultSettings();
    }

    /**
     * Default settings.
     */
    private function defaultSettings(): array
    {
        return [
            'periode' => 'Periode 2025/2026',
            'subtitle' => 'Dedikasi dan Inovasi untuk Generasi Berencana Periode 2025/2026 PIK-R REQUEST SMAN 1 Tasik Putri Puyu',
            'bagan_image' => null,
            'bagan_pdf' => null,
        ];
    }

    /**
     * Update settings.
     */
    public function updateSettings(array $data): void
    {
        $settings = $this->getSettings();

        $settings['periode'] = $data['periode'] ?? $settings['periode'];
        $settings['subtitle'] = $data['subtitle'] ?? $settings['subtitle'];

        if (isset($data['bagan_image']) && $data['bagan_image'] instanceof UploadedFile) {
            $this->deleteImage($settings['bagan_image']);
            $settings['bagan_image'] = app(ImageCompressionService::class)->compressAndUpload(
                file: $data['bagan_image'],
                directory: 'uploads/structures',
                maxWidth: 1920,
                quality: 85
            );
        }

        if (isset($data['bagan_pdf']) && $data['bagan_pdf'] instanceof UploadedFile) {
            $this->deleteImage($settings['bagan_pdf']);
            $uploadPath = public_path('uploads/documents');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            $filename = 'bagan_struktur_' . time() . '.' . $data['bagan_pdf']->getClientOriginalExtension();
            $data['bagan_pdf']->move($uploadPath, $filename);
            $settings['bagan_pdf'] = 'uploads/documents/' . $filename;
        }

        file_put_contents(storage_path('app/struktur_settings.json'), json_encode($settings, JSON_PRETTY_PRINT));
    }

    public function getAllStructures()
    {
        return OrganizationStructure::orderBy('order_index', 'asc')->orderBy('created_at', 'desc')->get();
    }

    public function getPaginatedStructures(int $perPage = 10, ?string $search = null)
    {
        return OrganizationStructure::when($search, function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('position', 'like', "%{$search}%");
            })
            ->orderBy('order_index', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getStructureById(int $id)
    {
        return OrganizationStructure::findOrFail($id);
    }

    public function createStructure(array $data)
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->uploadImage($data['image']);
        }

        return OrganizationStructure::create($data);
    }

    public function updateStructure(int $id, array $data)
    {
        $structure = $this->getStructureById($id);

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $this->deleteImage($structure->image);
            $data['image'] = $this->uploadImage($data['image']);
        }

        $structure->update($data);
        return $structure;
    }

    public function deleteStructure(int $id)
    {
        $structure = $this->getStructureById($id);
        $this->deleteImage($structure->image);
        return $structure->delete();
    }

    private function uploadImage(UploadedFile $file): string
    {
        return app(ImageCompressionService::class)->compressAndUpload(
            file: $file,
            directory: 'uploads/structures',
            maxWidth: 1200,
            quality: 82
        );
    }

    private function deleteImage(?string $path): void
    {
        app(ImageCompressionService::class)->delete($path);
    }
}
