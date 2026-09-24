<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\PushSubscription;
use Illuminate\Support\Facades\Log;
use Minishlink\WebPush\WebPush;

class WebPushService
{
    protected ?WebPush $webPush = null;

    /**
     * Initialize WebPush instance with VAPID credentials.
     */
    protected function getWebPush(): ?WebPush
    {
        if (file_exists(app_path('Support/Base64UrlPolyfill.php'))) {
            require_once app_path('Support/Base64UrlPolyfill.php');
        }

        if ($this->webPush) {
            return $this->webPush;
        }

        $vapid = config('webpush.vapid');

        if (empty($vapid['public_key']) || empty($vapid['private_key'])) {
            Log::warning('WebPush VAPID keys not configured. Push notifications are disabled.');
            return null;
        }

        $auth = [
            'VAPID' => [
                'subject' => $vapid['subject'] ?? 'mailto:pikr.request@gmail.com',
                'publicKey' => $vapid['public_key'],
                'privateKey' => $vapid['private_key'],
            ],
        ];

        $defaultOptions = config('webpush.client_options', [
            'TTL' => 259200,
            'urgency' => 'normal',
        ]);

        $this->webPush = new WebPush($auth, $defaultOptions);
        $this->webPush->setAutomaticPadding(false);

        return $this->webPush;
    }

    /**
     * Send notification (saves to Database and dispatches Web Push).
     */
    public function send(
        string $title,
        string $message,
        ?string $url = null,
        string $type = 'informasi',
        ?string $icon = null,
        ?int $userId = null,
        bool $broadcastPush = true,
        array $data = []
    ): Notification {
        $icon = $icon ?: config('webpush.default_icon', '/assets/img/Logo_pikr.png');

        // 1. Save to Database Notification Center
        $notification = Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'url' => $url,
            'icon' => $icon,
            'is_read' => false,
            'is_sent' => false,
            'data' => $data,
        ]);

        // 2. Dispatch Push Notification if enabled
        if ($broadcastPush) {
            $pushResult = $this->dispatchWebPush($notification);
            $notification->data = array_merge($notification->data ?? [], $pushResult);
            $notification->save();
        }

        return $notification;
    }

    /**
     * Dispatch Web Push notifications to active subscriptions.
     */
    public function dispatchWebPush(Notification $notification): array
    {
        $webPush = $this->getWebPush();
        if (!$webPush) {
            return ['success' => 0, 'failed' => 0, 'error' => 'WebPush client not configured'];
        }

        // Fetch subscriptions (for target user or all active subscribers)
        $query = PushSubscription::where('is_active', true);
        if ($notification->user_id) {
            $query->where('user_id', $notification->user_id);
        }
        $subscriptions = $query->get();

        if ($subscriptions->isEmpty()) {
            $notification->update([
                'is_sent' => true,
                'sent_at' => now(),
            ]);
            return ['success' => 0, 'failed' => 0, 'message' => 'No active subscribers found'];
        }

        $payload = json_encode([
            'id' => $notification->id,
            'title' => $notification->title,
            'body' => $notification->message,
            'url' => $notification->url ?: url('/notifikasi'),
            'icon' => asset($notification->icon ?: config('webpush.default_icon', '/assets/img/Logo_pikr.png')),
            'badge' => asset(config('webpush.default_badge', '/assets/img/Logo_pikr.png')),
            'type' => $notification->type,
            'sent_at' => now()->toIso8601String(),
        ]);

        // Queue notifications in WebPush
        foreach ($subscriptions as $sub) {
            try {
                $webPushSubscription = $sub->toWebPushSubscription();
                $webPush->queueNotification($webPushSubscription, $payload);
            } catch (\Throwable $e) {
                Log::error("Failed to queue push for subscription ID {$sub->id}: " . $e->getMessage());
            }
        }

        $successCount = 0;
        $failedCount = 0;

        // Flush and process results
        try {
            foreach ($webPush->flush() as $report) {
                $endpoint = $report->getRequest()->getUri()->__toString();
                
                if ($report->isSuccess()) {
                    $successCount++;
                } else {
                    $failedCount++;
                    Log::warning("WebPush send failed for endpoint {$endpoint}: " . $report->getReason());

                    // If subscription has expired or is unsubscribed (404, 410), deactivate it
                    if ($report->isSubscriptionExpired()) {
                        PushSubscription::where('endpoint_hash', hash('sha256', $endpoint))->update(['is_active' => false]);
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::error('WebPush flush error: ' . $e->getMessage());
        }

        $notification->update([
            'is_sent' => true,
            'sent_at' => now(),
        ]);

        return [
            'success' => $successCount,
            'failed' => $failedCount,
        ];
    }
}
