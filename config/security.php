<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Rate Limiting Configuration
    |--------------------------------------------------------------------------
    |
    | Configure rate limiting for authentication and API endpoints
    |
    */
    'rate_limiting' => [
        'max_attempts' => env('RATE_LIMIT_MAX_ATTEMPTS', 5),
        'decay_minutes' => env('RATE_LIMIT_DECAY_MINUTES', 1),
    ],

    /*
    |--------------------------------------------------------------------------
    | API Security Configuration
    |--------------------------------------------------------------------------
    |
    | Configure timeouts, retries and circuit breaker for external APIs
    |
    */
    'api' => [
        'timeout' => env('API_TIMEOUT', 10),
        'retry_attempts' => env('API_RETRY_ATTEMPTS', 3),
        'retry_delay' => env('API_RETRY_DELAY', 1000),
        'circuit_breaker' => [
            'failure_threshold' => env('CIRCUIT_BREAKER_FAILURE_THRESHOLD', 5),
            'recovery_timeout' => env('CIRCUIT_BREAKER_RECOVERY_TIMEOUT', 60),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Monitoring
    |--------------------------------------------------------------------------
    |
    | Configure security monitoring and alerting
    |
    */
    'monitoring' => [
        'enabled' => env('SECURITY_MONITORING_ENABLED', true),
        'alert_threshold' => env('SECURITY_ALERT_THRESHOLD', 10),
        'log_failed_attempts' => env('LOG_FAILED_ATTEMPTS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Institutional Login Configuration
    |--------------------------------------------------------------------------
    |
    | Secure configuration for institutional authentication
    |
    */
    'institutional' => [
        'username' => env('INSTITUTIONAL_USERNAME'),
        'password' => env('INSTITUTIONAL_PASSWORD'),
    ],
];