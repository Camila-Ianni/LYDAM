<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class PayPalService
{
    public function createOrder(Order $order): array
    {
        $payload = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'reference_id' => (string) $order->id,
                'amount' => [
                    'currency_code' => config('services.paypal.currency', 'USD'),
                    'value' => number_format((float) $order->total, 2, '.', ''),
                ],
            ]],
            'application_context' => [
                'return_url' => route('payments.paypal.capture', $order),
                'cancel_url' => route('payments.paypal.cancel', $order),
            ],
        ];

        if (! $this->hasCredentials()) {
            return [
                'reference' => 'paypal-local-'.$order->id,
                'approval_url' => route('checkout.success', $order),
                'raw' => ['mode' => 'local-placeholder', 'payload' => $payload],
            ];
        }

        $response = Http::withToken($this->accessToken())
            ->acceptJson()
            ->post($this->baseUrl().'/v2/checkout/orders', $payload)
            ->throw()
            ->json();

        return [
            'reference' => $response['id'] ?? null,
            'approval_url' => $this->approvalUrl($response),
            'raw' => $response,
        ];
    }

    public function captureOrder(string $paypalOrderId): array
    {
        if (! $this->hasCredentials()) {
            return [
                'reference' => $paypalOrderId,
                'status' => str_starts_with($paypalOrderId, 'paypal-local-') ? 'paid' : 'unknown',
                'raw' => ['mode' => 'local-placeholder'],
            ];
        }

        $response = Http::withToken($this->accessToken())
            ->acceptJson()
            ->withBody('', 'application/json')
            ->post($this->baseUrl()."/v2/checkout/orders/{$paypalOrderId}/capture")
            ->throw()
            ->json();

        return [
            'reference' => $response['id'] ?? $paypalOrderId,
            'status' => ($response['status'] ?? null) === 'COMPLETED' ? 'paid' : ($response['status'] ?? null),
            'raw' => $response,
        ];
    }

    private function accessToken(): string
    {
        $response = Http::withBasicAuth(
            config('services.paypal.client_id'),
            config('services.paypal.client_secret'),
        )
            ->asForm()
            ->post($this->baseUrl().'/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ])
            ->throw()
            ->json();

        return $response['access_token'] ?? throw new RuntimeException('PayPal access token was not returned.');
    }

    private function approvalUrl(array $response): string
    {
        foreach ($response['links'] ?? [] as $link) {
            if (($link['rel'] ?? null) === 'approve') {
                return $link['href'];
            }
        }

        throw new RuntimeException('PayPal approval URL was not returned.');
    }

    private function baseUrl(): string
    {
        return config('services.paypal.base_url', 'https://api-m.sandbox.paypal.com');
    }

    private function hasCredentials(): bool
    {
        return (bool) config('services.paypal.client_id')
            && (bool) config('services.paypal.client_secret');
    }
}
