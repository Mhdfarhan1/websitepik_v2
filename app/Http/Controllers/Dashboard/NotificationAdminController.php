<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Activity;
use App\Models\News;
use App\Models\Notification;
use App\Models\PushSubscription;
use App\Models\TributeEdition;
use App\Services\WebPushService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NotificationAdminController extends Controller
{
    public function __construct(protected WebPushService $webPushService)
    {
    }

    /**
     * Show notification management & content queue dashboard.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');

        // 1. Ambil Notifikasi Riwayat (History)
        $query = Notification::query()
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%")->orWhere('message', 'like', "%{$search}%"))
            ->when($type, fn($q) => $q->where('type', $type))
            ->latest();

        $notifications = $query->paginate(10)->withQueryString();

        // 2. Ambil Konten Terbaru dari Seluruh Fitur Website
        $recentAchievements = Achievement::latest('id')->take(8)->get()->map(function ($item) {
            $url = route('prestasi.show', $item->id);
            return [
                'id' => 'prestasi_' . $item->id,
                'source_type' => 'prestasi',
                'badge_icon' => '🏆',
                'badge_label' => 'Prestasi',
                'badge_color' => 'bg-amber-100 text-amber-800 border-amber-200',
                'title' => $item->title,
                'subtitle' => 'Tanggal: ' . ($item->date ? $item->date->format('d M Y') : $item->created_at->format('d M Y')),
                'url' => $url,
                'created_at' => $item->created_at ?: now(),
                'default_title' => 'Prestasi Baru 🏆: ' . $item->title,
                'default_message' => 'PIK-R REQUEST mengukir prestasi membanggakan: "' . Str::limit($item->title, 70) . '". Lihat selengkapnya!',
                'is_notified' => Notification::where('url', $url)->exists(),
            ];
        });

        $recentActivities = Activity::latest('id')->take(8)->get()->map(function ($item) {
            $url = route('kegiatan.show', $item->slug);
            return [
                'id' => 'kegiatan_' . $item->id,
                'source_type' => 'kegiatan',
                'badge_icon' => '📅',
                'badge_label' => 'Kegiatan',
                'badge_color' => 'bg-blue-100 text-blue-800 border-blue-200',
                'title' => $item->title,
                'subtitle' => 'Jadwal: ' . ($item->event_date ? $item->event_date->format('d M Y') : '') . ' • Lokasi: ' . ($item->location ?: '-'),
                'url' => $url,
                'created_at' => $item->created_at ?: now(),
                'default_title' => 'Kegiatan Baru 📅: ' . $item->title,
                'default_message' => 'Agenda terbaru PIK-R REQUEST: "' . Str::limit($item->title, 70) . '". Yuk cek jadwal & lokasinya!',
                'is_notified' => Notification::where('url', $url)->exists(),
            ];
        });

        $recentNews = News::latest('id')->take(8)->get()->map(function ($item) {
            $url = route('news.show', $item->slug);
            return [
                'id' => 'artikel_' . $item->id,
                'source_type' => 'artikel',
                'badge_icon' => '📰',
                'badge_label' => 'Artikel & Berita',
                'badge_color' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                'title' => $item->title,
                'subtitle' => 'Diterbitkan: ' . ($item->published_at ? $item->published_at->format('d M Y') : $item->created_at->format('d M Y')),
                'url' => $url,
                'created_at' => $item->published_at ?: ($item->created_at ?: now()),
                'default_title' => 'Artikel Edukasi 📰: ' . $item->title,
                'default_message' => 'Artikel edukasi terbaru telah tersedia: "' . Str::limit($item->title, 70) . '". Baca artikel selengkapnya!',
                'is_notified' => Notification::where('url', $url)->exists(),
            ];
        });

        $recentTributes = TributeEdition::latest('id')->take(8)->get()->map(function ($item) {
            $url = url('/profil/jejak-bakti?periode=' . urlencode($item->period));
            return [
                'id' => 'jejak_bakti_' . $item->id,
                'source_type' => 'jejak_bakti',
                'badge_icon' => '👑',
                'badge_label' => 'Jejak Bakti',
                'badge_color' => 'bg-purple-100 text-purple-800 border-purple-200',
                'title' => $item->title . ' (Periode ' . $item->period . ')',
                'subtitle' => 'Duta GenRe Periode ' . $item->period,
                'url' => $url,
                'created_at' => $item->created_at ?: now(),
                'default_title' => 'Jejak Bakti Baru 👑: ' . $item->title,
                'default_message' => 'Rekam Jejak Duta GenRe telah diperbarui untuk periode ' . $item->period . '. Simak kisah inspiratifnya!',
                'is_notified' => Notification::where('url', $url)->exists(),
            ];
        });

        // Gabungkan seluruh konten terbaru dan urutkan dari yang paling baru
        $availableContents = collect()
            ->concat($recentAchievements)
            ->concat($recentActivities)
            ->concat($recentNews)
            ->concat($recentTributes)
            ->sortByDesc('created_at')
            ->values();

        // 3. Statistik Realtime
        $stats = [
            'total_subscribers' => PushSubscription::count(),
            'active_subscribers' => PushSubscription::where('is_active', true)->count(),
            'total_notifications' => Notification::count(),
            'total_sent_push' => Notification::where('is_sent', true)->count(),
            'pending_contents' => $availableContents->where('is_notified', false)->count(),
        ];

        return view('pages.dashboard.notifications.index', compact('notifications', 'availableContents', 'stats'));
    }

    /**
     * Quick send notification directly from a content card with 1-click.
     */
    public function quickSend(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'message' => 'required|string|max:255',
            'type' => 'required|string|in:prestasi,jejak_bakti,kegiatan,artikel,pengumuman,informasi,berita',
            'url' => 'required|string|max:255',
        ]);

        try {
            $notification = $this->webPushService->send(
                title: $validated['title'],
                message: $validated['message'],
                url: $validated['url'],
                type: $validated['type'],
                icon: config('webpush.default_icon', '/assets/img/Logo_pikr.png'),
                userId: null,
                broadcastPush: true
            );

            $successCount = $notification->data['success'] ?? 0;
            return back()->with('success', "Notifikasi untuk \"{$validated['title']}\" berhasil disiarkan! Terkirim ke {$successCount} subscriber device.");
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menyiarkan notifikasi: ' . $e->getMessage());
        }
    }

    /**
     * Combine & broadcast multiple selected contents in ONE notification (Anti-Spam feature).
     */
    public function batchSend(Request $request)
    {
        $items = $request->input('selected_items', []);

        if (empty($items) || !is_array($items)) {
            return back()->with('error', 'Silakan pilih minimal 1 konten untuk disiarkan.');
        }

        $decodedItems = [];
        foreach ($items as $itemJson) {
            $data = json_decode($itemJson, true);
            if ($data && !empty($data['title'])) {
                $decodedItems[] = $data;
            }
        }

        if (empty($decodedItems)) {
            return back()->with('error', 'Data konten yang dipilih tidak valid.');
        }

        $count = count($decodedItems);

        // Jika hanya 1 item, kirim notifikasi spesifik item tersebut
        if ($count === 1) {
            $item = $decodedItems[0];
            $notification = $this->webPushService->send(
                title: $item['default_title'] ?? $item['title'],
                message: $item['default_message'] ?? ('Ada pembaruan konten terbaru: ' . $item['title']),
                url: $item['url'] ?? url('/notifikasi'),
                type: $item['source_type'] ?? 'informasi',
                broadcastPush: true
            );
            $successCount = $notification->data['success'] ?? 0;
            if ($successCount > 0) {
                return back()->with('success', "Notifikasi berhasil disiarkan ke {$successCount} subscriber device!");
            }
            return back()->with('success', "Notifikasi disimpan di Pusat Notifikasi. Belum ada HP yang aktif (0 perangkat terkirim). Buka website di HP Anda lalu izinkan notifikasi agar HP terhubung.");
        }

        // Jika 2 atau lebih, buat notifikasi gabungan (Anti-Spam Grouping)
        $titleSummary = collect($decodedItems)->pluck('title')->map(fn($t) => Str::limit($t, 30))->implode(', ');
        $title = "{$count} Konten Baru di PIK-R REQUEST 📢";
        $message = "Terdapat {$count} pembaruan: {$titleSummary}. Ketuk untuk melihat semuanya!";
        $url = route('notifications.index');

        try {
            $notification = $this->webPushService->send(
                title: $title,
                message: Str::limit($message, 250),
                url: $url,
                type: 'pengumuman',
                broadcastPush: true
            );

            $successCount = $notification->data['success'] ?? 0;
            if ($successCount > 0) {
                return back()->with('success', "Berhasil menggabungkan {$count} konten ke dalam 1 notifikasi siaran! Terkirim ke {$successCount} subscriber device.");
            }
            return back()->with('success', "Konten berhasil disimpan ke Pusat Notifikasi. Belum ada subscriber aktif (0 perangkat). Buka website di HP Anda untuk mendaftarkan perangkat.");
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menggabungkan notifikasi: ' . $e->getMessage());
        }
    }

    /**
     * Send manual broadcast push notification with custom title & message.
     */
    public function sendManual(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'message' => 'required|string|max:255',
            'type' => 'required|string|in:prestasi,jejak_bakti,kegiatan,artikel,pengumuman,informasi,berita',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'broadcast_push' => 'nullable|boolean',
        ]);

        $url = $validated['url'] ? (str_starts_with($validated['url'], 'http') ? $validated['url'] : url($validated['url'])) : url('/');
        $icon = $validated['icon'] ?: config('webpush.default_icon', '/assets/img/Logo_pikr.png');
        $broadcastPush = $request->boolean('broadcast_push', true);

        try {
            $notification = $this->webPushService->send(
                title: $validated['title'],
                message: $validated['message'],
                url: $url,
                type: $validated['type'],
                icon: $icon,
                userId: null,
                broadcastPush: $broadcastPush
            );

            $recipientCount = $notification->data['success'] ?? 0;
            $failedCount = $notification->data['failed'] ?? 0;

            return back()->with('success', "Notifikasi berhasil disiarkan! Terkirim ke {$recipientCount} subscriber device (Gagal: {$failedCount}).");
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menyiarkan notifikasi: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Delete notification history.
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();
        return back()->with('success', 'Riwayat notifikasi berhasil dihapus.');
    }
}
