<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Stripe\StripeClient;

class Subscribe
{
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->user() && !$request->user()->tenant->subscribed('default')) {
            if ($request->user()->owner) {
                $stripe = new StripeClient(env('STRIPE_SECRET'));

                $session = $stripe->checkout->sessions->create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price' => 'price_1QLpFdFoXtF9L8nL8fzWvX4C', // Substitua pelo ID do preço
                        'quantity' => 1,
                    ]],
                    'mode' => 'subscription',
                    'success_url' => env('APP_URL') . '/sucesso?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => env('APP_URL') . '/cancelado',
                ]);

                return response()->json([
                    'action'  => 'subscribe',
                    'url'     => $session->url,
                    'message' => 'Redirecionando para o pagamento da assinatura.',
                ], 403);
            }

            return response()->json([
                'action'  => 'logout',
                'url'     => null,
                'message' => 'Estabelecimento sem assinatura ativa.',
            ], 403);
        }

        return $next($request);
    }
}
