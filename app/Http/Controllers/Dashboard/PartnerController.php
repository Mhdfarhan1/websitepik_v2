<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $partners = Partner::when($search, function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
            
        return view('pages.dashboard.partners.index', compact('partners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,svg|max:5120',
        ]);

        $logoPath = $request->file('logo')->store('partners', 'public');

        Partner::create([
            'name' => $request->name,
            'logo' => $logoPath,
        ]);

        return back()->with('success', 'Mitra berhasil ditambahkan.');
    }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:5120',
        ]);

        $partner->name = $request->name;

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }
            $partner->logo = $request->file('logo')->store('partners', 'public');
        }

        $partner->save();

        return back()->with('success', 'Data mitra berhasil diperbarui.');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->logo) {
            Storage::disk('public')->delete($partner->logo);
        }
        $partner->delete();

        return back()->with('success', 'Mitra berhasil dihapus.');
    }
}
