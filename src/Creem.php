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
     * Get a product by ID.
     * Retrieve a single product by its ID.
     *
     * Sends a GET request to the '/products/{id}' endpoint to fetch product details.
     *
     * @param string $id The unique identifier of the product to retrieve.
     * @return Response The HTTP response from the CREEM API, containing the product details.
     */
    public function getProduct(string $id): Response
    {
        return $this->request('GET', "/products/{$id}");
    }

    /**
     * Retrieve a list of all products.
     *
     * Sends a GET request to the '/products' endpoint to fetch all available products.
     *
     * @return Response The HTTP response from the CREEM API, containing a collection of products.
     */
    public function getProducts(): Response
    {
        return $this->request('GET', '/products');
    }

    /**
     * Search for products.
     *
     * Sends a GET request to the '/products/search' endpoint to fetch all available products.
     * This endpoint supports pagination and returns a list of products with metadata.
     *
     * @param array $params Optional query parameters (e.g., page, limit, filters)
     * @return Response The HTTP response from the CREEM API, containing paginated products.
     */
    public function searchProducts(array $params = []): Response
    {
        $queryString = !empty($params) ? '?' . http_build_query($params) : '';
        return $this->request('GET', '/products/search' . $queryString);
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
     * Get a coupon details.
     *
     * @param string $id
     * @return Response
     */
    public function getCoupon(string $id): Response
    {
        return $this->request('GET', "/coupons/{$id}");
    }

    /**
     * Create a customer portal link.
     *
     * @param array $params
     * @return Response
     */
    public function createPortalLink(array $params): Response
    {
        return $this->request('POST', "/customer-portal", $params);
    }

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
