<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileSettingController extends Controller
{
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Show index settings page.
     */
    public function index()
    {
        $settings = $this->profileService->getProfileSetting();
        $milestones = $this->profileService->getAllMilestones();

        return view('pages.dashboard.profile-settings.index', compact('settings', 'milestones'));
    }

    /**
     * Update profile settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'sejarah_title' => 'required|string|max:255',
            'pembina_name' => 'required|string|max:255',
            'pembina_period' => 'required|string|max:255',
            'pembina_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'pembina_pantun' => 'nullable|string',
            'pembina_speech' => 'nullable|string',
            'about_title' => 'required|string|max:255',
            'about_content' => 'nullable|string',
            'about_video_url' => 'nullable|url|max:255',
            'visi_text' => 'nullable|string',
            'misi_text' => 'nullable|string',
            'visi_misi_bg' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
            
            'pilar_1_title' => 'nullable|string|max:255',
            'pilar_1_desc' => 'nullable|string',
            'pilar_2_title' => 'nullable|string|max:255',
            'pilar_2_desc' => 'nullable|string',
            'pilar_3_title' => 'nullable|string|max:255',
            'pilar_3_desc' => 'nullable|string',
            'pilar_4_title' => 'nullable|string|max:255',
            'pilar_4_desc' => 'nullable|string',
            
            'renstra_text' => 'nullable|string|max:255',
            'renstra_file' => 'nullable|file|mimes:pdf|max:10240', // 10MB
            
            'tujuan_text' => 'nullable|string',
            'sasaran_text' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('visi_misi_bg')) {
            $data['visi_misi_bg'] = app(\App\Services\ImageCompressionService::class)->compressAndUpload(
                file: $request->file('visi_misi_bg'),
                directory: 'profile',
                maxWidth: 1920,
                quality: 80,
                disk: 'public'
            );
        }
        
        if ($request->hasFile('renstra_file')) {
            $data['renstra_file'] = $request->file('renstra_file')->store('profile', 'public');
        }

        $this->profileService->updateProfileSetting($data);

        return back()->with('success', 'Pengaturan profil berhasil diperbarui.');
    }

    /**
     * Store new history milestone.
     */
    public function storeMilestone(Request $request)
    {
        $request->validate([
            'year' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $this->profileService->addMilestone($request->all());

        return back()->with('success', 'Milestone sejarah berhasil ditambahkan.');
    }

    /**
     * Update history milestone.
     */
    public function updateMilestone(Request $request, $id)
    {
        $request->validate([
            'year' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $this->profileService->updateMilestone($id, $request->all());

        return back()->with('success', 'Milestone sejarah berhasil diperbarui.');
    }

    /**
     * Delete history milestone.
     */
    public function destroyMilestone($id)
    {
        $this->profileService->deleteMilestone($id);

        return back()->with('success', 'Milestone sejarah berhasil dihapus.');
    }
}
