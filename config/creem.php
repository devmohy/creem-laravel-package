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
     */
    'api_base_url' => env('CREEM_API_BASE_URL', 'https://api.creem.io/v1'),
];
