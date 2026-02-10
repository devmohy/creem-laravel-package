<?php

namespace Creem\CreemLaravel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyWebhookSignature
{
    /**
     * Handle an incoming CREEM webhook request.
     *
     * Verifies the authenticity of the request by checking the 'creem-signature'
     * header against the locally configured webhook secret using HMAC-SHA256.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException If signature is invalid.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $signature = $request->header('creem-signature');
        $secret = config('creem.webhook_secret');

        if (! $signature || ! $secret) {
            return response()->json(['message' => 'Invalid signature or secret configuration'], 401);
        }

        $payload = $request->getContent();
        $computedSignature = hash_hmac('sha256', $payload, $secret);

        if (! hash_equals($computedSignature, $signature)) {
            return response()->json(['message' => 'Invalid signature'], 401);
        }

        return $next($request);
    }
}
