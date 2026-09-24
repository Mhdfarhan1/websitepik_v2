<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PushSubscriptionController extends Controller
{
    /**
     * Get the VAPID Public Key for the frontend.
     */
    public function vapidPublicKey(): JsonResponse
    {
        $publicKey = config('webpush.vapid.public_key');

        if (!$publicKey) {
            return response()->json([
                'status' => 'error',
                'message' => 'VAPID public key belum dikonfigurasi.',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'public_key' => $publicKey,
        ]);
    }

    /**
     * Store or update a push subscription from the browser.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'endpoint' => 'required|string',
            'keys.p256dh' => 'required|string',
            'keys.auth' => 'required|string',
            'contentEncoding' => 'nullable|string',
        ]);

        $endpoint = $request->input('endpoint');
        $endpointHash = hash('sha256', $endpoint);

        $subscription = PushSubscription::updateOrCreate(
            ['endpoint_hash' => $endpointHash],
            [
                'user_id' => Auth::id(), // null jika user belum login
                'endpoint' => $endpoint,
                'public_key' => $request->input('keys.p256dh'),
                'auth_token' => $request->input('keys.auth'),
                'content_encoding' => $request->input('contentEncoding', 'aesgcm'),
                'is_active' => true,
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Langganan notifikasi push berhasil disimpan!',
            'data' => [
                'id' => $subscription->id,
                'is_active' => $subscription->is_active,
            ],
        ], 201);
    }

    /**
     * Unsubscribe a browser endpoint.
     */
    public function destroy(Request $request): JsonResponse
    {
        $request->validate([
            'endpoint' => 'required|string',
        ]);

        $endpointHash = hash('sha256', $request->input('endpoint'));

        PushSubscription::where('endpoint_hash', $endpointHash)->update([
            'is_active' => false,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Langganan notifikasi berhasil dinonaktifkan.',
        ]);
    }
}
