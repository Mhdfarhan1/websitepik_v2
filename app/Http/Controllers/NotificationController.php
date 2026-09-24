<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display all notifications page.
     */
    public function index(Request $request): View
    {
        $category = $request->query('kategori', 'semua');
        $filter = $request->query('status', 'semua');

        $query = Notification::query()->latest();

        // Scope to current logged-in user or general announcements
        if (Auth::check()) {
            $query->where(function ($q) {
                $q->where('user_id', Auth::id())->orWhereNull('user_id');
            });
        } else {
            $query->whereNull('user_id');
        }

        // Filter by unread status
        if ($filter === 'unread' || $category === 'unread') {
            $query->where('is_read', false);
        }

        // Filter by category type
        if (!in_array($category, ['semua', 'unread'])) {
            $query->where('type', $category);
        }

        $notifications = $query->paginate(12)->withQueryString();

        // Count unread
        $unreadCount = Notification::query()
            ->when(Auth::check(), fn($q) => $q->where(fn($sq) => $sq->where('user_id', Auth::id())->orWhereNull('user_id')), fn($q) => $q->whereNull('user_id'))
            ->where('is_read', false)
            ->count();

        // Counts per category
        $categoryCounts = [
            'semua' => Notification::query()->when(Auth::check(), fn($q) => $q->where(fn($sq) => $sq->where('user_id', Auth::id())->orWhereNull('user_id')), fn($q) => $q->whereNull('user_id'))->count(),
            'unread' => $unreadCount,
            'prestasi' => Notification::query()->when(Auth::check(), fn($q) => $q->where(fn($sq) => $sq->where('user_id', Auth::id())->orWhereNull('user_id')), fn($q) => $q->whereNull('user_id'))->where('type', 'prestasi')->count(),
            'jejak_bakti' => Notification::query()->when(Auth::check(), fn($q) => $q->where(fn($sq) => $sq->where('user_id', Auth::id())->orWhereNull('user_id')), fn($q) => $q->whereNull('user_id'))->where('type', 'jejak_bakti')->count(),
            'kegiatan' => Notification::query()->when(Auth::check(), fn($q) => $q->where(fn($sq) => $sq->where('user_id', Auth::id())->orWhereNull('user_id')), fn($q) => $q->whereNull('user_id'))->where('type', 'kegiatan')->count(),
            'artikel' => Notification::query()->when(Auth::check(), fn($q) => $q->where(fn($sq) => $sq->where('user_id', Auth::id())->orWhereNull('user_id')), fn($q) => $q->whereNull('user_id'))->whereIn('type', ['artikel', 'berita'])->count(),
            'pengumuman' => Notification::query()->when(Auth::check(), fn($q) => $q->where(fn($sq) => $sq->where('user_id', Auth::id())->orWhereNull('user_id')), fn($q) => $q->whereNull('user_id'))->where('type', 'pengumuman')->count(),
        ];

        return view('pages.notifications.index', compact('notifications', 'category', 'filter', 'unreadCount', 'categoryCounts'));
    }

    /**
     * Get unread count for navbar badge.
     */
    public function getUnreadCount(): JsonResponse
    {
        $count = Notification::query()
            ->when(Auth::check(), fn($q) => $q->where(fn($sq) => $sq->where('user_id', Auth::id())->orWhereNull('user_id')), fn($q) => $q->whereNull('user_id'))
            ->where('is_read', false)
            ->count();

        return response()->json([
            'count' => $count,
        ]);
    }

    /**
     * Get recent notifications for navbar dropdown.
     */
    public function getRecent(): JsonResponse
    {
        $notifications = Notification::query()
            ->when(Auth::check(), fn($q) => $q->where(fn($sq) => $sq->where('user_id', Auth::id())->orWhereNull('user_id')), fn($q) => $q->whereNull('user_id'))
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($notif) {
                return [
                    'id' => $notif->id,
                    'title' => $notif->title,
                    'message' => $notif->message,
                    'type' => $notif->type,
                    'type_label' => $notif->type_label,
                    'type_icon' => $notif->type_icon,
                    'type_badge' => $notif->type_badge_class,
                    'url' => $notif->url ?: route('notifications.read', $notif->id),
                    'read_url' => route('notifications.read', $notif->id),
                    'is_read' => $notif->is_read,
                    'time_ago' => $notif->created_at ? $notif->created_at->diffForHumans() : '',
                ];
            });

        return response()->json([
            'data' => $notifications,
        ]);
    }

    /**
     * Mark a single notification as read and redirect to target URL.
     */
    public function markAsRead(Request $request, int $id): JsonResponse|RedirectResponse
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_read' => true]);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Notifikasi ditandai sebagai sudah dibaca.',
            ]);
        }

        // If clicked from UI, redirect to the target page or notifications list
        return redirect()->to($notification->url ?: route('notifications.index'));
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request): JsonResponse|RedirectResponse
    {
        Notification::query()
            ->when(Auth::check(), fn($q) => $q->where(fn($sq) => $sq->where('user_id', Auth::id())->orWhereNull('user_id')), fn($q) => $q->whereNull('user_id'))
            ->where('is_read', false)
            ->update(['is_read' => true]);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Semua notifikasi berhasil ditandai telah dibaca.',
            ]);
        }

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }
}
