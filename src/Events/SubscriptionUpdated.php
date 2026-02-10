<?php

namespace Creem\CreemLaravel\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionUpdated
{
    use Dispatchable, SerializesModels;

    /**
     * The webhook payload for the updated subscription.
     *
     * @var array
     */
    public array $payload;

    /**
     * Create a new event instance.
     *
     * @param array $payload The subscription update payload.
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }
}
