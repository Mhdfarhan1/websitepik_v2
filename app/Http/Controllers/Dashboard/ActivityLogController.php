<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $logs = \App\Models\ActivityLog::with('user')
            ->when($search, function($query) use ($search) {
                $query->where('description', 'like', "%{$search}%")
                      ->orWhere('action', 'like', "%{$search}%")
                      ->orWhereHas('user', function($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();
            
        return view('pages.dashboard.activity-logs.index', compact('logs'));
    }
}
