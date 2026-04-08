<?php

return [

    'defaults' => [
        'guard' => 'web',          // default guard
        'passwords' => 'users',    // default password provider
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // Student Guard
        'student' => [
            'driver' => 'session',
            'provider' => 'students',
        ],

        // Subadmin Guard
        'subadmin' => [
            'driver' => 'session',
            'provider' => 'subadmins',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // Student Provider
        'students' => [
            'driver' => 'eloquent',
            'model' => App\Models\Student::class,
        ],

        // Subadmin Provider
        'subadmins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Subadmin::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        // Optional: Student password reset
        'students' => [
            'provider' => 'students',
            'table' => 'student_password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
