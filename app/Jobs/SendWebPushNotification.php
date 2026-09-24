<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Services\WebPushService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWebPushNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 10;

    /**
     * Create a new job instance.
     */
    public function __construct(public Notification $notification)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(WebPushService $webPushService): void
    {
        try {
            $results = $webPushService->dispatchWebPush($this->notification);
            Log::info("WebPush Job completed for Notification ID #{$this->notification->id}:", $results);
        } catch (\Throwable $e) {
            Log::error("WebPush Job failed for Notification ID #{$this->notification->id}: " . $e->getMessage());
            throw $e;
        }
    }
}
