<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    /**
     * Log an activity.
     *
     * @param string $action
     * @param string $description
     * @param string|null $modelType
     * @param int|null $modelId
     * @return ActivityLog
     */
    public static function log(string $action, string $description, ?string $modelType = null, ?int $modelId = null)
    {
        return ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'description' => $description,
            'ip_address' => request()->ip(),
        ]);
    }
}
