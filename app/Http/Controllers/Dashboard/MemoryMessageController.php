<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\MemoryMessageService;
use Illuminate\Http\Request;

class MemoryMessageController extends Controller
{
    protected MemoryMessageService $service;

    public function __construct(MemoryMessageService $service)
    {
        $this->service = $service;
    }

    /**
     * Display Jejak Rasa management dashboard.
     */
    public function index(Request $request)
    {
        $setting = $this->service->getSetting();
        $status = $request->query('status');
        $messages = $this->service->getAllMessagesForAdmin($status);
        $silentMoments = $this->service->getSilentMoments(false);
        $farewellLetters = $this->service->getFarewellLetters(false);

        return view('pages.dashboard.memory-messages.index', compact(
            'setting',
            'messages',
            'silentMoments',
            'farewellLetters',
            'status'
        ));
    }

    /**
     * Update page settings & ambient audio.
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'badge_title' => 'required|string|max:255',
            'page_title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'audio_title' => 'nullable|string|max:255',
            'audio_artist' => 'nullable|string|max:255',
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a,aac|max:25600',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
            'is_audio_active' => 'nullable|boolean',
            'remove_audio' => 'nullable|boolean',
        ]);

        $validated['is_audio_active'] = $request->has('is_audio_active');

        $this->service->updateSetting($validated);

        return redirect()->route('dashboard.memory-messages.index')
            ->with('success', 'Pengaturan Jejak Rasa berhasil diperbarui.');
    }

    /**
     * Store unsaid message by Admin.
     */
    public function storeMessage(Request $request)
    {
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:120',
            'sender_name' => 'nullable|string|max:100',
            'sender_role' => 'nullable|string|max:100',
            'generation' => 'nullable|string|max:80',
            'category' => 'required|in:terima_kasih,maaf,rindu,pesan_adik,catatan_pembina',
            'message' => 'required|string|min:5|max:5000',
            'hug_count' => 'nullable|integer|min:0',
            'is_pinned' => 'nullable|boolean',
            'is_approved' => 'nullable|boolean',
        ]);

        $validated['is_pinned'] = $request->has('is_pinned');
        $validated['is_approved'] = $request->has('is_approved');
        $validated['hug_count'] = $validated['hug_count'] ?? 0;

        $this->service->storeMessage($validated);

        return redirect()->route('dashboard.memory-messages.index', ['tab' => 'messages'])
            ->with('success', 'Surat kenangan berhasil ditambahkan oleh Admin.');
    }

    /**
     * Update unsaid message by Admin.
     */
    public function updateMessage(Request $request, int $id)
    {
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:120',
            'sender_name' => 'nullable|string|max:100',
            'sender_role' => 'nullable|string|max:100',
            'generation' => 'nullable|string|max:80',
            'category' => 'required|in:terima_kasih,maaf,rindu,pesan_adik,catatan_pembina',
            'message' => 'required|string|min:5|max:5000',
            'hug_count' => 'nullable|integer|min:0',
            'is_pinned' => 'nullable|boolean',
            'is_approved' => 'nullable|boolean',
        ]);

        $validated['is_pinned'] = $request->has('is_pinned');
        $validated['is_approved'] = $request->has('is_approved');

        $this->service->updateMessage($id, $validated);

        return redirect()->route('dashboard.memory-messages.index', ['tab' => 'messages'])
            ->with('success', 'Surat kenangan berhasil diperbarui.');
    }

    /**
     * Toggle approval of a message.
     */
    public function toggleApproval(int $id)
    {
        $approved = $this->service->toggleApproval($id);
        $statusText = $approved ? 'ditampilkan di publik' : 'disembunyikan (pending)';
        return back()->with('success', "Surat berhasil {$statusText}.");
    }

    /**
     * Toggle pinned status of a message.
     */
    public function togglePin(int $id)
    {
        $pinned = $this->service->togglePin($id);
        $pinText = $pinned ? 'disematkan di urutan teratas' : 'dilepas dari sematan';
        return back()->with('success', "Surat berhasil {$pinText}.");
    }

    /**
     * Delete an unsaid message.
     */
    public function destroyMessage(int $id)
    {
        $this->service->deleteMessage($id);
        return back()->with('success', 'Surat kenangan berhasil dihapus.');
    }

    /**
     * Store silent room moment.
     */
    public function storeMoment(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'period' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'narrative' => 'required|string',
            'order_index' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order_index'] = $validated['order_index'] ?? 0;

        $this->service->storeSilentMoment($validated);

        return redirect()->route('dashboard.memory-messages.index', ['tab' => 'moments'])
            ->with('success', 'Momen "Ruang yang Kini Sunyi" berhasil ditambahkan.');
    }

    /**
     * Update silent room moment.
     */
    public function updateMoment(Request $request, int $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'period' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'narrative' => 'required|string',
            'order_index' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $this->service->updateSilentMoment($id, $validated);

        return redirect()->route('dashboard.memory-messages.index', ['tab' => 'moments'])
            ->with('success', 'Momen "Ruang yang Kini Sunyi" berhasil diperbarui.');
    }

    /**
     * Destroy silent room moment.
     */
    public function destroyMoment(int $id)
    {
        $this->service->deleteSilentMoment($id);
        return redirect()->route('dashboard.memory-messages.index', ['tab' => 'moments'])
            ->with('success', 'Momen berhasil dihapus.');
    }

    /**
     * Store farewell letter.
     */
    public function storeFarewell(Request $request)
    {
        $validated = $request->validate([
            'generation_title' => 'required|string|max:255',
            'period' => 'required|string|max:100',
            'author_representative' => 'nullable|string|max:255',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'excerpt' => 'nullable|string|max:500',
            'letter_content' => 'required|string',
            'order_index' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order_index'] = $validated['order_index'] ?? 0;

        $this->service->storeFarewellLetter($validated);

        return redirect()->route('dashboard.memory-messages.index', ['tab' => 'farewells'])
            ->with('success', 'Surat Pamit Demisioner berhasil disimpan.');
    }

    /**
     * Update farewell letter.
     */
    public function updateFarewell(Request $request, int $id)
    {
        $validated = $request->validate([
            'generation_title' => 'required|string|max:255',
            'period' => 'required|string|max:100',
            'author_representative' => 'nullable|string|max:255',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'excerpt' => 'nullable|string|max:500',
            'letter_content' => 'required|string',
            'order_index' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $this->service->updateFarewellLetter($id, $validated);

        return redirect()->route('dashboard.memory-messages.index', ['tab' => 'farewells'])
            ->with('success', 'Surat Pamit Demisioner berhasil diperbarui.');
    }

    /**
     * Destroy farewell letter.
     */
    public function destroyFarewell(int $id)
    {
        $this->service->deleteFarewellLetter($id);
        return redirect()->route('dashboard.memory-messages.index', ['tab' => 'farewells'])
            ->with('success', 'Surat Pamit Demisioner berhasil dihapus.');
    }
}
