<?php

namespace App\Http\Controllers;

use App\Services\MemoryMessageService;
use Illuminate\Http\Request;

class MemoryMessagePublicController extends Controller
{
    /**
     * Display public Jejak Rasa page.
     */
    public function index(Request $request, MemoryMessageService $service)
    {
        $setting = $service->getSetting();
        $selectedCategory = $request->query('kategori', 'all');
        $selectedGeneration = $request->query('angkatan', 'all');
        $search = $request->query('q');

        $messages = $service->getApprovedMessages($selectedCategory, $selectedGeneration, $search);
        $generations = $service->getAvailableGenerations();
        $silentMoments = $service->getSilentMoments(true);
        $farewellLetters = $service->getFarewellLetters(true);

        return view('pages.jejak-rasa', compact(
            'setting',
            'messages',
            'generations',
            'silentMoments',
            'farewellLetters',
            'selectedCategory',
            'selectedGeneration',
            'search'
        ));
    }

    /**
     * Store public unsaid message.
     */
    public function store(Request $request, MemoryMessageService $service)
    {
        $validated = $request->validate([
            'sender_name' => 'nullable|string|max:100',
            'sender_role' => 'nullable|string|max:100',
            'recipient_name' => 'required|string|max:120',
            'generation' => 'nullable|string|max:80',
            'category' => 'required|in:terima_kasih,maaf,rindu,pesan_adik,catatan_pembina',
            'message' => 'required|string|min:5|max:3000',
            'paper_theme' => 'nullable|in:warm,vintage,night,rose,navy',
        ], [
            'recipient_name.required' => 'Mohon tuliskan untuk siapa surat/pesan ini ditujukan.',
            'category.required' => 'Pilih kategori rasa untuk surat ini.',
            'message.required' => 'Tuliskan pesan atau kenangan Anda.',
            'message.min' => 'Pesan minimal 5 karakter.',
        ]);

        $service->storeMessage($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Surat kenangan Anda berhasil tertaut di Jejak Rasa.'
            ]);
        }

        return redirect()->route('jejak-rasa')->with('success', 'Surat kenangan Anda telah terabadikan dengan indah di Jejak Rasa.');
    }

    /**
     * Increment hug counter via AJAX.
     */
    public function hug(Request $request, int $id, MemoryMessageService $service)
    {
        $newCount = $service->incrementHug($id);

        return response()->json([
            'success' => true,
            'hug_count' => $newCount,
        ]);
    }
}
