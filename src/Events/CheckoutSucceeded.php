<?php

namespace Creem\CreemLaravel\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CheckoutSucceeded
{
    use Dispatchable, SerializesModels;

    /**
     * The webhook payload for the successful checkout.
     *
     * @var array
     */
    public array $payload;

    /**
     * Create a new event instance.
     *
     * @param array $payload The checkout success payload.
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }
}
