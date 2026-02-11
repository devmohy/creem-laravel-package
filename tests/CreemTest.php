<?php

namespace Creem\CreemLaravel\Tests;

use Illuminate\Support\Facades\Http;
use Creem\CreemLaravel\Facades\Creem;

class CreemTest extends TestCase
{
    /** @test */
    public function it_can_create_a_checkout_session()
    {
        Http::fake([
            'https://api.creem.io/v1/checkouts' => Http::response(['checkout_url' => 'https://creem.io/checkout/123'], 201),
        ]);

        $response = Creem::createCheckout(['product_id' => 'prod_123']);

        $this->assertTrue($response->successful());
        $this->assertEquals('https://creem.io/checkout/123', $response->json('checkout_url'));
        
        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.creem.io/v1/checkouts' &&
                   $request->method() === 'POST' &&
                   $request->hasHeader('x-api-key', 'test_api_key') &&
                   $request['product_id'] === 'prod_123';
        });
    }

    /** @test */
    public function it_can_get_a_product()
    {
        Http::fake([
            'https://api.creem.io/v1/products/prod_123' => Http::response(['id' => 'prod_123', 'name' => 'Test Product'], 200),
        ]);

        $response = Creem::getProduct('prod_123');

        $this->assertTrue($response->successful());
        $this->assertEquals('prod_123', $response->json('id'));
        $this->assertEquals('Test Product', $response->json('name'));
    }

    /** @test */
    public function it_can_get_all_products()
    {
        Http::fake([
            'https://api.creem.io/v1/products/search*' => Http::response([
                ['id' => 'prod_1', 'name' => 'Product 1'],
                ['id' => 'prod_2', 'name' => 'Product 2'],
            ], 200),
        ]);

        $response = Creem::getProducts();

        $this->assertTrue($response->successful());
        $this->assertCount(2, $response->json());
    }

    /** @test */
    public function it_can_cancel_a_subscription()
    {
        Http::fake([
            'https://api.creem.io/v1/subscriptions/sub_123/cancel' => Http::response(['status' => 'cancelled'], 200),
        ]);

        $response = Creem::cancelSubscription('sub_123');

        $this->assertTrue($response->successful());
        $this->assertEquals('cancelled', $response->json('status'));
    }

    /** @test */
    public function it_can_update_a_subscription()
    {
        Http::fake([
            'https://api.creem.io/v1/subscriptions/sub_123' => Http::response(['id' => 'sub_123', 'plan_id' => 'plan_new'], 200),
        ]);

        $response = Creem::updateSubscription('sub_123', ['plan_id' => 'plan_new']);

        $this->assertTrue($response->successful());
        $this->assertEquals('plan_new', $response->json('plan_id'));
    }

    /** @test */
    public function it_can_get_a_coupon()
    {
        Http::fake([
            'https://api.creem.io/v1/discounts*' => Http::response(['code' => 'COUPON10', 'percent_off' => 10], 200),
        ]);

        $response = Creem::getCoupon('COUPON10');

        $this->assertTrue($response->successful());
        $this->assertEquals(10, $response->json('percent_off'));
    }

    /** @test */
    public function it_can_create_a_portal_link()
    {
        Http::fake([
            'https://api.creem.io/v1/customers/billing' => Http::response(['customer_portal_link' => 'https://creem.io/portal/123'], 200),
        ]);

        $response = Creem::createPortalLink(['customer_id' => 'cus_123']);

        $this->assertTrue($response->successful());
        $this->assertEquals('https://creem.io/portal/123', $response->json('customer_portal_link'));
    }
}
