<?php

namespace Creem\CreemLaravel\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WebhookReceived
{
    use Dispatchable, SerializesModels;

    /**
     * The raw webhook payload received from CREEM.
     *
     * @var array
     */
    public array $payload;

    /**
     * Create a new event instance.
     *
     * @param array $payload The webhook payload.
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }
}
