<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Stripe\StripeClient;

class SubscribeController extends Controller
{
    public function subscribeBronzePlan()
    {
        $stripe = new StripeClient(env('STRIPE_SECRET'));

        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => 'price_1QLybqFoXtF9L8nLtVdes1iX',
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => env('APP_WEBAPP'),
        ]);

        return response()->json([
            'action' => 'subscribe',
            'url'    => $session->url,
        ], 201);
    }

    public function subscribeSilverPlan()
    {
        $stripe = new StripeClient(env('STRIPE_SECRET'));

        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => 'price_1QLpFdFoXtF9L8nL8fzWvX4C',
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => env('APP_WEBAPP'),
        ]);

        return response()->json([
            'action' => 'subscribe',
            'url'    => $session->url,
        ], 201);
    }

    public function subscribeGoldPlan()
    {
        $stripe = new StripeClient(env('STRIPE_SECRET'));

        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => 'price_1QLyaKFoXtF9L8nL7J3pFtc5',
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => env('APP_WEBAPP'),
        ]);

        return response()->json([
            'action' => 'subscribe',
            'url'    => $session->url,
        ], 201);
    }
}

//CARD: 4000000760000002

//stripe listen --forward-to localhost/webhook
