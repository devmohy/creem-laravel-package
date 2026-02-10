<?php

namespace App\Listeners;

use Creem\CreemLaravel\Events\CheckoutSucceeded;
use Illuminate\Support\Facades\Log;

class CreemWebhookListener
{
    /**
     * Handle the event.
     */
    public function handle(CheckoutSucceeded $event): void
    {
        $payload = $event->payload;
        $customerId = $payload['customer_id'] ?? 'unknown';

        Log::info("CREEM Webhook Received: Checkout Succeeded for Customer {$customerId}", [
            'raw_payload' => $payload
        ]);

        // In a real app, you would:
        // 1. Find the user by customer_id or metadata
        // 2. Set their status to 'active'
        // 3. Update their subscription expiry date
    }
}
