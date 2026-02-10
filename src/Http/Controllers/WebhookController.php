<?php

namespace Creem\CreemLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Creem\CreemLaravel\Events\WebhookReceived;

class WebhookController extends Controller
{
    /**
     * Handle the incoming CREEM webhook.
     *
     * Dispatches a general WebhookReceived event and a specific event
     * based on the 'type' field in the webhook payload.
     *
     * @param Request $request The incoming HTTP request from CREEM.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success.
     */
    public function __invoke(Request $request)
    {
        $payload = $request->all();
        $type = $payload['type'] ?? null;

        // Dispatch general event
        WebhookReceived::dispatch($payload);

        // Dispatch specific event if type is provided
        if ($type) {
            $eventClass = 'Creem\\CreemLaravel\\Events\\' . Str::studly(str_replace('.', '_', $type));
            
            if (class_exists($eventClass)) {
                $eventClass::dispatch($payload);
            }
        }

        return response()->json(['message' => 'Webhook processed successfully']);
    }
}
