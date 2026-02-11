<?php

namespace App\Http\Controllers;

use Creem\CreemLaravel\Facades\Creem;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        // Fetch products from CREEM API using search endpoint
        $response = Creem::searchProducts();
        
        if ($response->successful()) {
            $data = $response->json();
            $products = $data['items'] ?? [];
            
            // Transform CREEM products to match our view structure
            $plans = collect($products)->map(function ($product) {
                // Format price with currency
                $price = isset($product['price']) && isset($product['currency'])
                    ? number_format($product['price'] / 100, 2) . ' ' . $product['currency']
                    : 'N/A';
                
                // Extract billing period
                $interval = match($product['billing_period'] ?? 'every-month') {
                    'every-month' => 'month',
                    'every-year' => 'year',
                    'every-week' => 'week',
                    default => 'month',
                };
                
                // Extract features
                $features = collect($product['features'] ?? [])->map(function ($feature) {
                    return $feature['description'] ?? 'Feature';
                })->toArray();
                
                return [
                    'id' => $product['id'],
                    'name' => $product['name'] ?? 'Unnamed Product',
                    'description' => $product['description'] ?? '',
                    'price' => '$' . number_format($product['price'] / 100, 2),
                    'interval' => $interval,
                    'features' => $features,
                ];
            })->toArray();
        } else {
            // Fallback to mock data if API fails
            $plans = [
                [
                    'id' => 'prod_3iDanWRyNB1pThObHPo8am',
                    'name' => 'Basic Plan',
                    'description' => 'Perfect for individuals',
                    'price' => '$9',
                    'interval' => 'month',
                    'features' => ['Track 10 scoops', 'Basic reporting', 'Email support'],
                ],
            ];
        }

        return view('pricing', compact('plans'));
    }

    public function checkout(Request $request)
    {
        $productId = $request->input('product_id');

        // Create a checkout session using the package
        // NOTE: Replace 'prod_basic' and 'prod_pro' in the pricing view
        // with actual product IDs from your CREEM dashboard
        $response = Creem::createCheckout([
            'product_id' => $productId,
            'request_id' => 'demo_' . uniqid(), // Optional: for idempotency
            'success_url' => route('dashboard') . '?session_id={CHECKOUT_SESSION_ID}',
        ]);
        
        if ($response->successful()) {
            return redirect($response->json('checkout_url'));
        }

        return back()->withErrors(['message' => 'Failed to create checkout. ' . $response->json('message')]);
    }
}
