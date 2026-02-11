<?php

namespace Creem\CreemLaravel;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class Creem
{
    /**
     * The CREEM configuration array.
     *
     * @var array
     */
    protected array $config;

    /**
     * Creem constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    // -------------------------------------------------------------------------
    // Checkouts
    // -------------------------------------------------------------------------

    /**
     * Create a checkout session.
     *
     * @param array $params
     * @return Response
     */
    public function createCheckout(array $params): Response
    {
        return $this->request('POST', '/checkouts', $params);
    }

    /**
     * Retrieve a checkout session.
     *
     * @param string $id
     * @return Response
     */
    public function getCheckout(string $id): Response
    {
        return $this->request('GET', "/checkouts/{$id}");
    }

    // -------------------------------------------------------------------------
    // Products
    // -------------------------------------------------------------------------

    /**
     * Create a new product.
     *
     * @param array $params
     * @return Response
     */
    public function createProduct(array $params): Response
    {
        return $this->request('POST', '/products', $params);
    }

    /**
     * Get a product by ID.
     *
     * @param string $id
     * @return Response
     */
    public function getProduct(string $id): Response
    {
        return $this->request('GET', "/products/{$id}");
    }

    /**
     * Search for products.
     *
     * @param array $params
     * @return Response
     */
    public function searchProducts(array $params = []): Response
    {
        $queryString = !empty($params) ? '?' . http_build_query($params) : '';
        return $this->request('GET', '/products/search' . $queryString);
    }

    /**
     * Retrieve a list of all products (alias for searchProducts).
     *
     * @param array $params
     * @return Response
     */
    public function getProducts(array $params = []): Response
    {
        return $this->searchProducts($params);
    }

    // -------------------------------------------------------------------------
    // Customers
    // -------------------------------------------------------------------------

    /**
     * Retrieve a customer.
     *
     * @param string $id The customer ID.
     * @return Response
     */
    public function getCustomer(string $id): Response
    {
        return $this->request('GET', '/customers', ['customer_id' => $id]);
    }

    /**
     * List all customers.
     *
     * @param array $params
     * @return Response
     */
    public function listCustomers(array $params = []): Response
    {
        $queryString = !empty($params) ? '?' . http_build_query($params) : '';
        return $this->request('GET', '/customers/list' . $queryString);
    }

    /**
     * Create a customer portal link.
     *
     * @param array $params
     * @return Response
     */
    public function createPortalLink(array $params): Response
    {
        return $this->request('POST', "/customers/billing", $params);
    }

    // -------------------------------------------------------------------------
    // Transactions
    // -------------------------------------------------------------------------

    /**
     * Get a transaction by ID.
     *
     * @param string $id
     * @return Response
     */
    public function getTransaction(string $id): Response
    {
        return $this->request('GET', '/transactions', ['transaction_id' => $id]);
    }

    /**
     * List all transactions.
     *
     * @param array $params
     * @return Response
     */
    public function listTransactions(array $params = []): Response
    {
        $queryString = !empty($params) ? '?' . http_build_query($params) : '';
        return $this->request('GET', '/transactions/search' . $queryString);
    }

    // -------------------------------------------------------------------------
    // Subscriptions
    // -------------------------------------------------------------------------

    /**
     * Retrieve a subscription.
     *
     * @param string $id
     * @return Response
     */
    public function getSubscription(string $id): Response
    {
        return $this->request('GET', '/subscriptions', ['subscription_id' => $id]);
    }

    /**
     * Update a subscription.
     *
     * @param string $id
     * @param array $params
     * @return Response
     */
    public function updateSubscription(string $id, array $params): Response
    {
        return $this->request('POST', "/subscriptions/{$id}", $params);
    }

    /**
     * Upgrade a subscription to a different product.
     *
     * @param string $id
     * @param array $params
     * @return Response
     */
    public function upgradeSubscription(string $id, array $params): Response
    {
        return $this->request('POST', "/subscriptions/{$id}/upgrade", $params);
    }

    /**
     * Pause a subscription.
     *
     * @param string $id
     * @return Response
     */
    public function pauseSubscription(string $id): Response
    {
        return $this->request('POST', "/subscriptions/{$id}/pause");
    }

    /**
     * Cancel a subscription.
     *
     * @param string $id
     * @return Response
     */
    public function cancelSubscription(string $id): Response
    {
        return $this->request('POST', "/subscriptions/{$id}/cancel");
    }

    // -------------------------------------------------------------------------
    // Licenses
    // -------------------------------------------------------------------------

    /**
     * Validate a license key.
     *
     * @param string $key
     * @param string $instanceId
     * @return Response
     */
    public function validateLicense(string $key, string $instanceId): Response
    {
        return $this->request('POST', '/licenses/validate', [
            'key' => $key,
            'instance_id' => $instanceId,
        ]);
    }

    /**
     * Activate a license key.
     *
     * @param string $key
     * @param string $instanceName
     * @return Response
     */
    public function activateLicense(string $key, string $instanceName): Response
    {
        return $this->request('POST', '/licenses/activate', [
            'key' => $key,
            'instance_name' => $instanceName,
        ]);
    }

    /**
     * Deactivate a license key instance.
     *
     * @param string $key
     * @param string $instanceId
     * @return Response
     */
    public function deactivateLicense(string $key, string $instanceId): Response
    {
        return $this->request('POST', '/licenses/deactivate', [
            'key' => $key,
            'instance_id' => $instanceId,
        ]);
    }

    // -------------------------------------------------------------------------
    // Discounts / Coupons
    // -------------------------------------------------------------------------

    /**
     * Create a discount.
     *
     * @param array $params
     * @return Response
     */
    public function createDiscount(array $params): Response
    {
        return $this->request('POST', '/discounts', $params);
    }

    /**
     * Retrieve a discount by ID or Code.
     *
     * @param string $identifier The discount ID or Code.
     * @return Response
     */
    public function getDiscount(string $identifier): Response
    {
        // Determine if the identifier is likely an ID (starts with 'disc_') or a code.
        // This simple heuristic provides a better DX by allowing a single argument.
        $param = str_starts_with($identifier, 'disc_') ? 'discount_id' : 'discount_code';
        
        return $this->request('GET', '/discounts', [$param => $identifier]);
    }
    
    /**
     * @deprecated Use getDiscount() instead.
     */
    public function getCoupon(string $id): Response
    {
        return $this->getDiscount($id);
    }

    /**
     * Delete a discount.
     *
     * @param string $id
     * @return Response
     */
    public function deleteDiscount(string $id): Response
    {
        return $this->request('DELETE', "/discounts/{$id}/delete");
    }

    // -------------------------------------------------------------------------
    // Core
    // -------------------------------------------------------------------------

    /**
     * Make a request to the CREEM API.
     *
     * @param string $method
     * @param string $endpoint
     * @param array $params
     * @return Response
     */
    protected function request(string $method, string $endpoint, array $params = []): Response
    {
        $apiKey = $this->config['api_key'] ?? '';
        $baseUrl = $this->config['api_base_url'] ?? 'https://api.creem.io/v1';

        $client = Http::withHeaders([
            'x-api-key' => $apiKey,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->baseUrl($baseUrl);

        return $client->{strtolower($method)}($endpoint, $params);
    }
}
