<?php

namespace App\Http\Controllers;

use Creem\CreemLaravel\Facades\Creem;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mock user subscription state
        $subscription = [
            'status' => 'active',
            'plan' => 'Pro Plan',
            'customer_id' => 'cus_123',
        ];

        return view('dashboard', compact('subscription'));
    }

    public function portal(Request $request)
    {
        // Generate a customer portal link using the package
        $response = Creem::createPortalLink([
            'customer_id' => 'cus_123', // From mock user
            'return_url' => route('dashboard'),
        ]);

        if ($response->successful()) {
            return redirect($response->json('portal_url'));
        }

        return back()->withErrors(['message' => 'Failed to create portal link.']);
    }
}
