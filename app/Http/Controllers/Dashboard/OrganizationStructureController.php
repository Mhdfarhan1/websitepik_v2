<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\OrganizationStructureService;
use Illuminate\Http\Request;

class OrganizationStructureController extends Controller
{
    protected OrganizationStructureService $structureService;

    public function __construct(OrganizationStructureService $structureService)
    {
        $this->structureService = $structureService;
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        $structures = $this->structureService->getPaginatedStructures($perPage, $search);
        $settings = $this->structureService->getSettings();
        
        return view('pages.dashboard.organization-structures.index', compact('structures', 'settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'order_index' => 'required|integer|min:0',
        ]);

        $data = $request->only(['name', 'position', 'order_index']);
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $this->structureService->createStructure($data);

        return back()->with('success', 'Pengurus berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'order_index' => 'required|integer|min:0',
        ]);

        $data = $request->only(['name', 'position', 'order_index']);
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $this->structureService->updateStructure($id, $data);

        return back()->with('success', 'Data pengurus berhasil diperbarui.');
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'periode' => 'nullable|string|max:100',
            'subtitle' => 'nullable|string',
            'bagan_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
            'bagan_pdf' => 'nullable|file|mimes:pdf|max:15360',
        ]);

        $data = $request->all();
        if ($request->hasFile('bagan_image')) {
            $data['bagan_image'] = $request->file('bagan_image');
        }
        if ($request->hasFile('bagan_pdf')) {
            $data['bagan_pdf'] = $request->file('bagan_pdf');
        }

        $this->structureService->updateSettings($data);

        return back()->with('success', 'Pengaturan bagan struktur dan periode berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $this->structureService->deleteStructure($id);
        
        return back()->with('success', 'Pengurus berhasil dihapus.');
    }
}
