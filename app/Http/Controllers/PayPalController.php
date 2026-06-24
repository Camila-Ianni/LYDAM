<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PayPalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PayPalController extends Controller
{
    public function __construct(private readonly PayPalService $payPalService)
    {
    }

    public function approve(Order $order): RedirectResponse
    {
        $paypalOrder = $this->payPalService->createOrder($order->load('items'));

        if ($paypalOrder['reference'] ?? null) {
            $order->update(['payment_reference' => $paypalOrder['reference']]);
        }

        return redirect()->away($paypalOrder['approval_url']);
    }

    public function capture(Order $order): RedirectResponse
    {
        $capture = $this->payPalService->captureOrder((string) $order->payment_reference);

        if (($capture['status'] ?? null) === 'paid') {
            $order->markAsPaid($capture['reference'] ?? null);

            return redirect()->route('checkout.success', $order);
        }

        return redirect()
            ->route('payments.paypal.cancel', $order)
            ->withErrors(['paypal' => __('No pudimos capturar el pago de PayPal.')]);
    }

    public function cancel(Order $order): View
    {
        return view('checkout.failure', [
            'order' => $order,
            'paymentId' => $order->payment_reference,
            'externalReference' => $order->id,
        ]);
    }
}
