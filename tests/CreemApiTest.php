<?php

namespace Creem\CreemLaravel\Tests;

use Illuminate\Support\Facades\Http;
use Creem\CreemLaravel\Facades\Creem;

class CreemApiTest extends TestCase
{
    // -------------------------------------------------------------------------
    // Checkouts
    // -------------------------------------------------------------------------
    
    /** @test */
    public function it_can_get_a_checkout_session()
    {
        Http::fake([
            'https://api.creem.io/v1/checkouts/chk_123' => Http::response(['id' => 'chk_123'], 200),
        ]);

        $response = Creem::getCheckout('chk_123');

        $this->assertTrue($response->successful());
        $this->assertEquals('chk_123', $response->json('id'));
    }

    // -------------------------------------------------------------------------
    // Products
    // -------------------------------------------------------------------------

    /** @test */
    public function it_can_create_a_product()
    {
        Http::fake([
            'https://api.creem.io/v1/products' => Http::response(['id' => 'prod_new', 'name' => 'New Product'], 201),
        ]);

        $response = Creem::createProduct(['name' => 'New Product', 'price' => 1000]);

        $this->assertTrue($response->successful());
        $this->assertEquals('prod_new', $response->json('id'));
    }

    /** @test */
    public function it_can_search_products()
    {
        Http::fake([
            'https://api.creem.io/v1/products/search*' => Http::response(['data' => [['id' => 'prod_1']]], 200),
        ]);

        $response = Creem::searchProducts(['limit' => 10]);

        $this->assertTrue($response->successful());
        $this->assertEquals('prod_1', $response->json('data.0.id'));
    }

    // -------------------------------------------------------------------------
    // Customers
    // -------------------------------------------------------------------------

    /** @test */
    public function it_can_get_a_customer()
    {
        Http::fake([
            'https://api.creem.io/v1/customers*' => Http::response(['id' => 'cus_123'], 200),
        ]);

        $response = Creem::getCustomer('cus_123');

        $this->assertTrue($response->successful());
        $this->assertEquals('cus_123', $response->json('id'));
    }

    /** @test */
    public function it_can_list_customers()
    {
        Http::fake([
            'https://api.creem.io/v1/customers/list*' => Http::response(['data' => [['id' => 'cus_1']]], 200),
        ]);

        $response = Creem::listCustomers(['page_size' => 10]);

        $this->assertTrue($response->successful());
    }

    /** @test */
    public function it_can_create_a_billing_portal_link()
    {
        Http::fake([
            'https://api.creem.io/v1/customers/billing' => Http::response(['customer_portal_link' => 'https://creem.io/portal/123'], 200),
        ]);

        $response = Creem::createPortalLink(['customer_id' => 'cus_123']);

        $this->assertTrue($response->successful());
        $this->assertEquals('https://creem.io/portal/123', $response->json('customer_portal_link'));
    }

    // -------------------------------------------------------------------------
    // Transactions
    // -------------------------------------------------------------------------

    /** @test */
    public function it_can_get_a_transaction()
    {
        Http::fake([
            'https://api.creem.io/v1/transactions*' => Http::response(['id' => 'txn_123'], 200),
        ]);

        $response = Creem::getTransaction('txn_123');

        $this->assertTrue($response->successful());
        $this->assertEquals('txn_123', $response->json('id'));
    }

    /** @test */
    public function it_can_list_transactions()
    {
        Http::fake([
            'https://api.creem.io/v1/transactions/search*' => Http::response(['data' => [['id' => 'txn_1']]], 200),
        ]);

        $response = Creem::listTransactions(['status' => 'succeeded']);

        $this->assertTrue($response->successful());
    }

    // -------------------------------------------------------------------------
    // Licenses
    // -------------------------------------------------------------------------

    /** @test */
    public function it_can_validate_a_license()
    {
        Http::fake([
            'https://api.creem.io/v1/licenses/validate' => Http::response(['status' => 'active'], 200),
        ]);

        $response = Creem::validateLicense('KEY-123', 'instance-1');

        $this->assertTrue($response->successful());
        $this->assertEquals('active', $response->json('status'));
    }

    /** @test */
    public function it_can_activate_a_license()
    {
        Http::fake([
            'https://api.creem.io/v1/licenses/activate' => Http::response(['status' => 'active'], 200),
        ]);

        $response = Creem::activateLicense('KEY-123', 'My Machine');

        $this->assertTrue($response->successful());
    }

    /** @test */
    public function it_can_deactivate_a_license()
    {
        Http::fake([
            'https://api.creem.io/v1/licenses/deactivate' => Http::response(['status' => 'inactive'], 200),
        ]);

        $response = Creem::deactivateLicense('KEY-123', 'instance-1');

        $this->assertTrue($response->successful());
    }

    // -------------------------------------------------------------------------
    // Discounts
    // -------------------------------------------------------------------------

    /** @test */
    public function it_can_create_a_discount()
    {
        Http::fake([
            'https://api.creem.io/v1/discounts' => Http::response(['id' => 'disc_123'], 201),
        ]);

        $response = Creem::createDiscount(['code' => 'SAVE20', 'percentage' => 20]);

        $this->assertTrue($response->successful());
        $this->assertEquals('disc_123', $response->json('id'));
    }

    /** @test */
    public function it_can_get_a_discount()
    {
        Http::fake([
            'https://api.creem.io/v1/discounts?discount_code=SAVE20' => Http::response(['code' => 'SAVE20'], 200),
        ]);

        $response = Creem::getDiscount('SAVE20');

        $this->assertTrue($response->successful());
        $this->assertEquals('SAVE20', $response->json('code'));
    }

    /** @test */
    public function it_can_delete_a_discount()
    {
        Http::fake([
            'https://api.creem.io/v1/discounts/disc_123/delete' => Http::response(['status' => 'deleted'], 200),
        ]);

        $response = Creem::deleteDiscount('disc_123');

        $this->assertTrue($response->successful());
    }

    // -------------------------------------------------------------------------
    // Subscriptions
    // -------------------------------------------------------------------------

    /** @test */
    public function it_can_get_a_subscription()
    {
        Http::fake([
            'https://api.creem.io/v1/subscriptions?subscription_id=sub_123' => Http::response(['id' => 'sub_123'], 200),
        ]);

        $response = Creem::getSubscription('sub_123');

        $this->assertTrue($response->successful());
        $this->assertEquals('sub_123', $response->json('id'));
    }

    /** @test */
    public function it_can_upgrade_a_subscription()
    {
        Http::fake([
            'https://api.creem.io/v1/subscriptions/sub_123/upgrade' => Http::response(['id' => 'sub_123'], 200),
        ]);

        $response = Creem::upgradeSubscription('sub_123', ['product_id' => 'prod_premium']);

        $this->assertTrue($response->successful());
    }

    /** @test */
    public function it_can_pause_a_subscription()
    {
        Http::fake([
            'https://api.creem.io/v1/subscriptions/sub_123/pause' => Http::response(['status' => 'paused'], 200),
        ]);

        $response = Creem::pauseSubscription('sub_123');

        $this->assertTrue($response->successful());
    }
}
