<?php

namespace Creem\CreemLaravel\Tests;

use Creem\CreemLaravel\CreemServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            CreemServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        config()->set('creem.api_key', 'test_api_key');
        config()->set('creem.webhook_secret', 'test_secret');
    }
}
