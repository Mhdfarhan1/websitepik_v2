<?php

return [
    'vapid' => [
        'subject' => env('VAPID_SUBJECT', 'mailto:pikr.request@gmail.com'),
        'public_key' => env('VAPID_PUBLIC_KEY'),
        'private_key' => env('VAPID_PRIVATE_KEY'),
    ],

    // Default icon and badge for PIK-R REQUEST Web Push
    'default_icon' => env('WEBPUSH_DEFAULT_ICON', '/assets/img/Logo_pikr.png'),
    'default_badge' => env('WEBPUSH_DEFAULT_BADGE', '/assets/img/Logo_pikr.png'),

    // Automatic TTL in seconds (default: 3 days)
    'client_options' => [
        'TTL' => 259200,
        'urgency' => 'normal',
    ],
];
