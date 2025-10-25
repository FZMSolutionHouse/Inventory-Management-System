<?php
// File: config/auth.php
// This is the corrected configuration.

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users', // Changed from 'registrations'
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users', // Changed from 'registrations'
        ],
    ],

    // In config/auth.php
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\createuser::class,
    ],
],

    'passwords' => [
        // This section must also match the provider name
        'users' => [
            'provider' => 'users', // Changed from 'registrations'
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];