<?php

namespace Creem\CreemLaravel;

use Illuminate\Support\ServiceProvider;
use Creem\CreemLaravel\Commands\SyncProductsCommand;
use Creem\CreemLaravel\Commands\WebhookSecretCommand;

class CreemServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/creem.php', 'creem');

        $this->app->singleton('creem', function ($app) {
            return new Creem($app['config']->get('creem'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/creem.php' => config_path('creem.php'),
            ], 'creem-config');

            $this->commands([
                WebhookSecretCommand::class,
                SyncProductsCommand::class,
            ]);
        }
    }
}
