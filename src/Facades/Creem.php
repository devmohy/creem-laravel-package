<?php

namespace Creem\CreemLaravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Http\Client\Response createCheckout(array $params)
 * @method static \Illuminate\Http\Client\Response getProduct(string $id)
 * @method static \Illuminate\Http\Client\Response getProducts()
 *
 * @see \Creem\CreemLaravel\Creem
 */
class Creem extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'creem';
    }
}
