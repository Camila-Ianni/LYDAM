<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MercadoPagoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MercadoPagoController extends Controller
{
    public function __construct(private readonly MercadoPagoService $mercadoPagoService)
    {
    }

    public function success(Request $request): View
    {
        $order = $this->resolveOrderFromRequest($request);

        if ($order && $request->query('payment_id')) {
            $order->markAsPaid((string) $request->query('payment_id'));
        }

        return view('checkout.success', [
            'order' => $order?->load('items.product'),
        ]);
    }

    public function pending(Request $request): View
    {
        return view('checkout.pending', [
            'paymentId' => $request->query('payment_id'),
            'externalReference' => $request->query('external_reference'),
        ]);
    }

    public function failure(Request $request): View
    {
        return view('checkout.failure', [
            'paymentId' => $request->query('payment_id'),
            'externalReference' => $request->query('external_reference'),
        ]);
    }

    public function webhook(Request $request): JsonResponse
    {
        $result = $this->mercadoPagoService->handleWebhook($request->all());

        if (($result['status'] ?? null) === 'paid' && ($result['external_reference'] ?? null)) {
            $order = Order::find($result['external_reference']);
            $order?->markAsPaid($result['payment_id'] ?? null);
        }

        return response()->json(['received' => true]);
    }

    private function resolveOrderFromRequest(Request $request): ?Order
    {
        $externalReference = $request->query('external_reference');

        if (! $externalReference) {
            return null;
        }

        return Order::find($externalReference);
    }
}
