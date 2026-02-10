<?php

namespace App\Http\Controllers;

use Creem\CreemLaravel\Facades\Creem;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        // For the demo, we'll mock some plans
        // In a real app, you might fetch these from Creem::getProducts()
        $plans = [
            [
                'id' => 'prod_basic',
                'name' => 'Basic Plan',
                'description' => 'Perfect for individuals',
                'price' => '$9',
                'interval' => 'month',
                'features' => ['Track 10 scoops', 'Basic reporting', 'Email support'],
            ],
            [
                'id' => 'prod_pro',
                'name' => 'Pro Plan',
                'description' => 'Best for small teams',
                'price' => '$29',
                'interval' => 'month',
                'features' => ['Unlimited scoops', 'Advanced analytics', 'Priority support', 'Custom branding'],
            ],
        ];

        return view('pricing', compact('plans'));
    }

    public function checkout(Request $request)
    {
        $productId = $request->input('product_id');

        // Create a checkout session using the package
        $response = Creem::createCheckout([
            'product_id' => $productId,
            'success_url' => route('dashboard') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('pricing'),
            'customer_email' => 'demo-user@example.com', // Mock user
        ]);

        if ($response->successful()) {
            return redirect($response->json('checkout_url'));
        }

        return back()->withErrors(['message' => 'Failed to create checkout. ' . $response->json('message')]);
    }
}
