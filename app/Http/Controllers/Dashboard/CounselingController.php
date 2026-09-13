<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Counseling;
use App\Services\CounselingService;
use Illuminate\Http\Request;

class CounselingController extends Controller
{
    protected $counselingService;

    public function __construct(CounselingService $counselingService)
    {
        $this->counselingService = $counselingService;
    }

    public function index()
    {
        $counselings = $this->counselingService->getPaginatedItems(10);
        return view('pages.dashboard.counselings.index', compact('counselings'));
    }

    public function create()
    {
        return view('pages.dashboard.counselings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'student_class' => 'nullable|string|max:255',
            'counselor_name' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'description' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $this->counselingService->createItem($validated);

        return redirect()->route('dashboard.counselings.index')->with('success', 'Data Konseling berhasil ditambahkan.');
    }

    public function edit(Counseling $counseling)
    {
        return view('pages.dashboard.counselings.edit', compact('counseling'));
    }

    public function update(Request $request, Counseling $counseling)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'student_class' => 'nullable|string|max:255',
            'counselor_name' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'description' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $this->counselingService->updateItem($counseling, $validated);

        return redirect()->route('dashboard.counselings.index')->with('success', 'Data Konseling berhasil diperbarui.');
    }

    public function destroy(Counseling $counseling)
    {
        $this->counselingService->deleteItem($counseling);

        return redirect()->route('dashboard.counselings.index')->with('success', 'Data Konseling berhasil dihapus.');
    }

    public static function getSettings(): array
    {
        $path = storage_path('app/counseling_settings.json');
        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true);
        }
        return [
            'hero_title_1' => 'Layanan',
            'hero_title_2' => 'Konseling Sebaya',
            'hero_desc' => 'Tempat aman dan nyaman bagi seluruh siswa SMAN 1 Tasik Putri Puyu untuk berkonsultasi, curhat, serta mendapatkan bimbingan seputar kesehatan reproduksi, kesehatan mental, hingga perencanaan masa depan.',
            'hero_bg' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=1600',
            'about_title' => 'Apa Itu Konseling Remaja?',
            'about_desc' => 'Konseling Remaja PIK-R REQUEST adalah bentuk pendampingan teman sebaya (Peer Counseling) yang dirancang untuk membantu remaja SMAN 1 Tasik Putri Puyu dalam menghadapi berbagai tantangan masa remaja. Melalui konseling ini, kamu bisa leluasa bercerita seputar kesehatan reproduksi, tekanan belajar, hubungan sosial, dan emosi diri secara aman, profesional, dan dijamin 100% RAHASIA.',
            'about_image' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&q=80&w=1200',
        ];
    }

    public function settings()
    {
        $settings = self::getSettings();
        return view('pages.dashboard.counselings.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'hero_title_1' => 'nullable|string|max:255',
            'hero_title_2' => 'nullable|string|max:255',
            'hero_desc' => 'nullable|string',
            'hero_bg' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'about_title' => 'nullable|string|max:255',
            'about_desc' => 'nullable|string',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $settings = self::getSettings();
        $settings['hero_title_1'] = $request->hero_title_1 ?? $settings['hero_title_1'];
        $settings['hero_title_2'] = $request->hero_title_2 ?? $settings['hero_title_2'];
        $settings['hero_desc'] = $request->hero_desc ?? $settings['hero_desc'];
        $settings['about_title'] = $request->about_title ?? $settings['about_title'];
        $settings['about_desc'] = $request->about_desc ?? $settings['about_desc'];

        if ($request->hasFile('hero_bg')) {
            $path = $request->file('hero_bg')->store('appearance', 'public');
            $settings['hero_bg'] = 'storage/' . $path;
        }

        if ($request->hasFile('about_image')) {
            $path = $request->file('about_image')->store('appearance', 'public');
            $settings['about_image'] = 'storage/' . $path;
        }

        file_put_contents(storage_path('app/counseling_settings.json'), json_encode($settings, JSON_PRETTY_PRINT));

        return redirect()->route('dashboard.counselings.settings')->with('success', 'Pengaturan Banner & Konten Layanan Konseling berhasil diperbarui!');
    }
}
