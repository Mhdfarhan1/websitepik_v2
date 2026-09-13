<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Counselor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CounselorController extends Controller
{
    public function index(Request $request)
    {
        $query = Counselor::orderBy('order_index', 'asc')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('class_or_title', 'like', "%{$search}%")
                  ->orWhere('bio_motto', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 10);
        $counselors = $query->paginate($perPage)->withQueryString();

        return view('pages.dashboard.counselors.index', compact('counselors'));
    }

    public function create()
    {
        return view('pages.dashboard.counselors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role_type' => 'required|string|in:konselor_sebaya,pendidik_sebaya,keduanya',
            'class_or_title' => 'nullable|string|max:255',
            'bio_motto' => 'nullable|string',
            'order_index' => 'nullable|integer',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = app(\App\Services\ImageCompressionService::class)->compressAndUpload(
                file: $request->file('photo'),
                directory: 'counselors',
                maxWidth: 1200,
                quality: 82,
                disk: 'public'
            );
        }

        Counselor::create([
            'name' => $request->name,
            'role_type' => $request->role_type,
            'class_or_title' => $request->class_or_title,
            'bio_motto' => $request->bio_motto,
            'order_index' => $request->order_index ?? 0,
            'photo' => $photoPath,
        ]);

        return redirect()->route('dashboard.counselors.index')->with('success', 'Data Konselor / Pendidik Sebaya berhasil ditambahkan!');
    }

    public function edit(Counselor $counselor)
    {
        return view('pages.dashboard.counselors.edit', compact('counselor'));
    }

    public function update(Request $request, Counselor $counselor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role_type' => 'required|string|in:konselor_sebaya,pendidik_sebaya,keduanya',
            'class_or_title' => 'nullable|string|max:255',
            'bio_motto' => 'nullable|string',
            'order_index' => 'nullable|integer',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
        ]);

        if ($request->hasFile('photo')) {
            if ($counselor->photo) {
                app(\App\Services\ImageCompressionService::class)->delete($counselor->photo, disk: 'public');
            }
            $counselor->photo = app(\App\Services\ImageCompressionService::class)->compressAndUpload(
                file: $request->file('photo'),
                directory: 'counselors',
                maxWidth: 1200,
                quality: 82,
                disk: 'public'
            );
        }

        $counselor->update([
            'name' => $request->name,
            'role_type' => $request->role_type,
            'class_or_title' => $request->class_or_title,
            'bio_motto' => $request->bio_motto,
            'order_index' => $request->order_index ?? 0,
        ]);

        return redirect()->route('dashboard.counselors.index')->with('success', 'Data Konselor / Pendidik Sebaya berhasil diperbarui!');
    }

    public function destroy(Counselor $counselor)
    {
        if ($counselor->photo) {
            app(\App\Services\ImageCompressionService::class)->delete($counselor->photo, disk: 'public');
        }

        $counselor->delete();

        return redirect()->route('dashboard.counselors.index')->with('success', 'Data Konselor / Pendidik Sebaya berhasil dihapus!');
    }
}
