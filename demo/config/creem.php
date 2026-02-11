<?php

return [
    /**
     * The CREEM API Key.
     * You can find this in your CREEM dashboard.
     */
    'api_key' => env('CREEM_API_KEY'),

    /**
     * The CREEM Webhook Secret.
     * Used to verify that the webhook requests are coming from CREEM.
     */
    'webhook_secret' => env('CREEM_WEBHOOK_SECRET'),

    /**
     * The base URL for the CREEM API.
     * Automatically switches between test and production:
     * - Test keys (creem_test_*): https://test-api.creem.io/v1
     * - Live keys (creem_live_*): https://api.creem.io/v1
     */
    'api_base_url' => env('CREEM_API_BASE_URL', function () {
        $apiKey = env('CREEM_API_KEY', '');
        return str_starts_with($apiKey, 'creem_test_')
            ? 'https://test-api.creem.io/v1'
            : 'https://api.creem.io/v1';
    }),
];
