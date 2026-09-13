<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('creator')->latest('event_date');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->input('per_page', 10);
        $activities = $query->paginate($perPage)->withQueryString();

        return view('pages.dashboard.activities.index', compact('activities'));
    }

    public function create()
    {
        return view('pages.dashboard.activities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'time_start' => 'required|string|max:10',
            'time_end' => 'nullable|string|max:10',
            'location' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'status' => 'required|in:upcoming,ongoing,completed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360', // Max 15MB
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = app(\App\Services\ImageCompressionService::class)->compressAndUpload(
                file: $request->file('image'),
                directory: 'activities',
                maxWidth: 1920,
                quality: 80,
                disk: 'public'
            );
        }

        Activity::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(4),
            'description' => $request->description,
            'event_date' => $request->event_date,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
            'location' => $request->location,
            'category' => $request->category,
            'status' => $request->status,
            'image' => $imagePath,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('dashboard.activities.index')->with('success', 'Kegiatan agenda berhasil ditambahkan!');
    }

    public function edit(Activity $activity)
    {
        return view('pages.dashboard.activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'time_start' => 'required|string|max:10',
            'time_end' => 'nullable|string|max:10',
            'location' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'status' => 'required|in:upcoming,ongoing,completed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360', // Max 15MB
        ]);

        if ($request->hasFile('image')) {
            if ($activity->image) {
                app(\App\Services\ImageCompressionService::class)->delete($activity->image, disk: 'public');
            }
            $activity->image = app(\App\Services\ImageCompressionService::class)->compressAndUpload(
                file: $request->file('image'),
                directory: 'activities',
                maxWidth: 1920,
                quality: 80,
                disk: 'public'
            );
        }

        $activity->update([
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
            'location' => $request->location,
            'category' => $request->category,
            'status' => $request->status,
        ]);

        return redirect()->route('dashboard.activities.index')->with('success', 'Kegiatan agenda berhasil diperbarui!');
    }

    public function destroy(Activity $activity)
    {
        if ($activity->image) {
            app(\App\Services\ImageCompressionService::class)->delete($activity->image, disk: 'public');
        }

        $activity->delete();

        return redirect()->route('dashboard.activities.index')->with('success', 'Kegiatan berhasil dihapus!');
    }

    public static function getSettings(): array
    {
        $path = storage_path('app/kegiatan_settings.json');
        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true);
        }
        return [
            'hero_title_1' => 'Agenda &',
            'hero_title_2' => 'Kegiatan Terjadwal',
            'hero_desc' => 'Jelajahi agenda sosialisasi kesehatan reproduksi remaja, pelatihan konselor sebaya, workshop edukasi GenRe, dan aksi nyata seputar remaja SMAN 1 Tasik Putri Puyu.',
            'hero_bg' => 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&q=80&w=1600',
        ];
    }

    public function settings()
    {
        $settings = self::getSettings();
        return view('pages.dashboard.activities.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'hero_title_1' => 'nullable|string|max:255',
            'hero_title_2' => 'nullable|string|max:255',
            'hero_desc' => 'nullable|string',
            'hero_bg' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $settings = self::getSettings();
        $settings['hero_title_1'] = $request->hero_title_1 ?? $settings['hero_title_1'];
        $settings['hero_title_2'] = $request->hero_title_2 ?? $settings['hero_title_2'];
        $settings['hero_desc'] = $request->hero_desc ?? $settings['hero_desc'];

        if ($request->hasFile('hero_bg')) {
            $path = $request->file('hero_bg')->store('appearance', 'public');
            $settings['hero_bg'] = 'storage/' . $path;
        }

        file_put_contents(storage_path('app/kegiatan_settings.json'), json_encode($settings, JSON_PRETTY_PRINT));

        return redirect()->route('dashboard.activities.settings')->with('success', 'Pengaturan Banner Halaman Kegiatan berhasil diperbarui!');
    }
}
