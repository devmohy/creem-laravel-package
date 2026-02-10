# CREEM Laravel Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/creem/creem-laravel.svg?style=flat-square)](https://packagist.org/packages/creem/creem-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/creem/creem-laravel.svg?style=flat-square)](https://packagist.org/packages/creem/creem-laravel)
[![License](https://img.shields.io/packagist/l/creem/creem-laravel.svg?style=flat-square)](https://packagist.org/packages/creem/creem-laravel)

Official Laravel package for [CREEM](https://creem.io), providing a clean, Laravel-native way to integrate payments, subscriptions, and webhooks.

## Features

- **Facade Support**: Simple API calls via `Creem::createCheckout()` and more.
- **Webhook Integration**: Middleware-protected webhook routing with automatic event dispatching.
- **Artisan Commands**: Easily manage your CREEM configuration and sync products.
- **SaaS Ready**: Designed for subscriptions and one-time payments.
- **CI/CD Ready**: Pre-configured GitHub Actions for automated testing.
- **Code Quality**: Built-in support for Laravel Pint to maintain clean code.

## Installation

You can install the package via composer:

```bash
composer require creem/creem-laravel
```

You should publish the config file with:

```bash
php artisan vendor:publish --tag="creem-config"
```

This is the contents of the published config file:

```php
return [
    'api_key' => env('CREEM_API_KEY'),
    'webhook_secret' => env('CREEM_WEBHOOK_SECRET'),
    'api_base_url' => env('CREEM_API_BASE_URL', 'https://api.creem.io/v1'),
];
```

## Usage

### Create a Checkout Session

```php
use Creem\CreemLaravel\Facades\Creem;

$response = Creem::createCheckout([
    'product_id' => 'prod_12345',
    'success_url' => route('checkout.success'),
    'cancel_url' => route('checkout.cancel'),
    'customer' => [
        'email' => 'user@example.com',
    ],
]);

if ($response->successful()) {
    $checkoutUrl = $response->json('checkout_url');
    return redirect($checkoutUrl);
}
```

### Get Product Details

```php
$product = Creem::getProduct('prod_12345');
$allProducts = Creem::getProducts();
```

### Subscription Management

```php
// Cancel a subscription
Creem::cancelSubscription('sub_123');

// Update a subscription (e.g., change plan)
Creem::updateSubscription('sub_123', [
    'plan_id' => 'plan_premium',
]);
```

### Customer Portal

Generate a secure link for users to manage their billing:

```php
$response = Creem::createPortalLink([
    'customer_id' => 'cus_123',
    'return_url' => route('dashboard'),
]);

return redirect($response->json('portal_url'));
```

### Coupons

```php
$coupon = Creem::getCoupon('SAVE10');
```

### Webhooks

To handle webhooks, you can use the built-in controller or define your own route using the provided middleware.

#### Built-in Route (Optional)

Add this to your `routes/api.php`:

```php
Route::post('/creem/webhook', \Creem\CreemLaravel\Http\Controllers\WebhookController::class)
    ->middleware(\Creem\CreemLaravel\Http\Middleware\VerifyWebhookSignature::class);
```

#### Events

The package dispatches events when a webhook is received:

- `Creem\CreemLaravel\Events\WebhookReceived`
- `Creem\CreemLaravel\Events\CheckoutSucceeded`
- `Creem\CreemLaravel\Events\SubscriptionUpdated`

You can listen to these events in your `EventServiceProvider`:

```php
protected $listen = [
    \Creem\CreemLaravel\Events\CheckoutSucceeded::class => [
        \App\Listeners\HandleSuccessfulPayment::class,
    ],
];
```

## Commands

### Set Webhook Secret

Generates or sets the `CREEM_WEBHOOK_SECRET` in your `.env` file.

```bash
php artisan creem:webhook-secret
```

### Sync/List Products

Fetches and displays all products from your CREEM dashboard.

```bash
php artisan creem:sync-products
```

## Testing

```bash
composer test
```

## Security

If you discover any security related issues, please email hello@creem.io instead of using the issue tracker.

## Credits

- [Mohammed Yayah](https://github.com/devmohy)
- [CREEM](https://github.com/creem)


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Community

- [Issue Tracker](https://github.com/devmohy/creem-laravel-package/issues)
- [Pull Requests](https://github.com/devmohy/creem-laravel-package/pulls)
- [Code of Conduct](CODE_OF_CONDUCT.md)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
