<?php

namespace App\Http\Controllers;

use App\Services\TimeCapsuleService;
use Illuminate\Http\Request;

class TimeCapsulePublicController extends Controller
{
    /**
     * Display public Kotak Waktu PIK-R page.
     */
    public function index(Request $request, TimeCapsuleService $timeCapsuleService, ?string $slug = null)
    {
        $setting = $timeCapsuleService->getSetting();
        $capsules = $timeCapsuleService->getAllCapsules(true);

        $selectedSlug = $slug ?: $request->query('kapsul');
        $activeCapsule = null;

        if ($selectedSlug) {
            $activeCapsule = $capsules->firstWhere('slug', $selectedSlug);
        }

        if (!$activeCapsule) {
            $activeCapsule = $capsules->firstWhere('is_featured', true) ?? $capsules->first();
        }

        // If an active capsule is found, load full relation items
        if ($activeCapsule) {
            $activeCapsule = $timeCapsuleService->getCapsuleById($activeCapsule->id);
        }

        return view('pages.kotak-waktu', compact('setting', 'capsules', 'activeCapsule'));
    }
}
