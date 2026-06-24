<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;

class MercadoPagoService
{
    public function createPreference(Order $order): array
    {
        $payload = [
            'external_reference' => (string) $order->id,
            'items' => $order->items->map(fn ($item): array => [
                'id' => (string) $item->product_id,
                'title' => $item->product_name,
                'quantity' => $item->quantity,
                'unit_price' => (float) $item->unit_price,
                'currency_id' => config('services.mercadopago.currency', 'ARS'),
            ])->values()->all(),
            'payer' => [
                'name' => $order->buyer_name,
                'email' => $order->buyer_email,
            ],
            'back_urls' => [
                'success' => route('payments.mercadopago.success'),
                'pending' => route('payments.mercadopago.pending'),
                'failure' => route('payments.mercadopago.failure'),
            ],
            'notification_url' => route('payments.mercadopago.webhook'),
            'auto_return' => 'approved',
        ];

        $accessToken = config('services.mercadopago.access_token');

        if (! $accessToken) {
            return [
                'reference' => 'mp-local-'.$order->id,
                'redirect_url' => route('checkout.success', $order),
                'raw' => ['mode' => 'local-placeholder', 'payload' => $payload],
            ];
        }

        $response = Http::withToken($accessToken)
            ->acceptJson()
            ->post('https://api.mercadopago.com/checkout/preferences', $payload)
            ->throw()
            ->json();

        return [
            'reference' => $response['id'] ?? null,
            'redirect_url' => $response['init_point'] ?? $response['sandbox_init_point'],
            'raw' => $response,
        ];
    }

    public function handleWebhook(array $payload): array
    {
        $paymentId = $payload['data']['id'] ?? $payload['id'] ?? null;
        $accessToken = config('services.mercadopago.access_token');

        if (! $paymentId || ! $accessToken) {
            return [
                'payment_id' => $paymentId,
                'status' => $payload['status'] ?? null,
                'external_reference' => $payload['external_reference'] ?? null,
                'raw' => $payload,
            ];
        }

        $payment = Http::withToken($accessToken)
            ->acceptJson()
            ->get("https://api.mercadopago.com/v1/payments/{$paymentId}")
            ->throw()
            ->json();

        return [
            'payment_id' => (string) $paymentId,
            'status' => ($payment['status'] ?? null) === 'approved' ? 'paid' : ($payment['status'] ?? null),
            'external_reference' => $payment['external_reference'] ?? null,
            'raw' => $payment,
        ];
    }
}
