<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\CompleteProfileService;
use Illuminate\Http\Request;

class CompleteProfileController extends Controller
{
    protected CompleteProfileService $profileService;

    public function __construct(CompleteProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Show configuration index view.
     */
    public function index()
    {
        $settings = $this->profileService->getSettings();
        return view('pages.dashboard.complete-profile.index', compact('settings'));
    }

    /**
     * Update complete profile settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_tag' => 'nullable|string|max:100',
            'hero_desc' => 'nullable|string',
            'hero_bg' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
            'hero_bg_color' => 'nullable|string|max:30',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240', // max 10MB
            
            // Biography
            'bio_name' => 'required|string|max:255',
            'bio_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'bio_content' => 'nullable|string',
            'bio_expertise' => 'nullable|string',
            'bio_hopes' => 'nullable|string',
            
            // Identity
            'org_name' => 'required|string|max:255',
            'org_abbreviation' => 'required|string|max:255',
            'org_year' => 'required|string|max:10',
            'org_base' => 'required|string|max:255',
            'org_philosophy' => 'nullable|string',
            
            // Regulations
            'reg_1_title' => 'nullable|string|max:255',
            'reg_1_desc' => 'nullable|string',
            'reg_2_title' => 'nullable|string|max:255',
            'reg_2_desc' => 'nullable|string',
            'reg_3_title' => 'nullable|string|max:255',
            'reg_3_desc' => 'nullable|string',
        ]);

        $this->profileService->updateSettings($request->all());

        return back()->with('success', 'Profil Lengkap berhasil diperbarui!');
    }
}
