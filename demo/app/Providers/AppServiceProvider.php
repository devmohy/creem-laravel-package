<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Creem\CreemLaravel\Events\CheckoutSucceeded;
use App\Listeners\CreemWebhookListener;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            CheckoutSucceeded::class,
            CreemWebhookListener::class
        );

        // Zero-config Demo Mocking
        // We use hardcoded paths instead of route() to prevent RouteNotFoundException during booting
        Http::fake([
            'https://api.creem.io/v1/checkouts' => Http::response([
                'checkout_url' => '/dashboard?mocked=true'
            ], 200),
            'https://api.creem.io/v1/customer-portal' => Http::response([
                'portal_url' => 'https://creem.io/mock-portal'
            ], 200),
        ]);
    }
}
