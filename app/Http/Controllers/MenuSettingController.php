<?php

namespace App\Http\Controllers;

use App\Models\MenuSetting;
use Illuminate\Http\Request;

class MenuSettingController extends Controller
{
    public function index()
    {
        $settings = MenuSetting::all();
        return view('pages.dashboard.menu-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Get all possible menu keys from the database
        $settings = MenuSetting::all();
        $inputSettings = $request->input('settings', []);

        foreach ($settings as $setting) {
            $setting->update([
                'pembina_visible' => isset($inputSettings[$setting->menu_key]['pembina']),
                'ketua_visible' => isset($inputSettings[$setting->menu_key]['ketua']),
            ]);
        }

        return back()->with('success', 'Pengaturan menu berhasil diperbarui.');
    }
}
