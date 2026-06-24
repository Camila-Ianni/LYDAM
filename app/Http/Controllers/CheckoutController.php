<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\MercadoPagoService;
use App\Services\PayPalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly MercadoPagoService $mercadoPagoService,
        private readonly PayPalService $payPalService,
    ) {
    }

    public function create(): View|RedirectResponse
    {
        $cart = session()->get('cart', []);

        if ($cart === []) {
            return redirect()->route('cart.index')->withErrors(['cart' => __('El carrito está vacío.')]);
        }

        return view('checkout.show', [
            'cart' => $cart,
            'total' => $this->cartTotal($cart),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'buyer_name' => ['required', 'string', 'max:255'],
            'buyer_dni' => ['required', 'string', 'max:20'],
            'buyer_email' => ['required', 'email', 'max:255'],
            'buyer_phone' => ['required', 'string', 'max:30'],
            'payment_method' => ['required', Rule::in([
                Order::PAYMENT_TRANSFER,
                Order::PAYMENT_MERCADOPAGO,
            ])],
        ]);

        $cart = session()->get('cart', []);

        if ($cart === []) {
            return redirect()->route('cart.index')->withErrors(['cart' => __('El carrito está vacío.')]);
        }

        $order = null;

        DB::beginTransaction();

        try {
            $productIds = array_map('intval', array_keys($cart));
            $products = Product::whereIn('id', $productIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $subtotal = 0;

            foreach ($cart as $productId => $item) {
                $product = $products->get((int) $productId);
                $quantity = (int) ($item['quantity'] ?? 0);

                if (! $product || ! $product->is_active) {
                    DB::rollBack();

                    return redirect()
                        ->route('cart.index')
                        ->withErrors(['cart' => __('Uno de los productos ya no está disponible.')]);
                }

                if ($quantity < 1 || $product->stock < $quantity) {
                    DB::rollBack();

                    return redirect()
                        ->route('cart.index')
                        ->withErrors(['stock' => __('No hay stock suficiente para :product.', [
                            'product' => $product->translatedName(),
                        ])]);
                }

                $subtotal += (float) $product->price * $quantity;
            }

            $order = Order::create([
                'user_id' => $request->user()?->id,
                'buyer_name' => $data['buyer_name'],
                'buyer_dni' => $data['buyer_dni'],
                'buyer_email' => $data['buyer_email'],
                'buyer_phone' => $data['buyer_phone'],
                'payment_method' => $data['payment_method'],
                'status' => Order::STATUS_PENDING,
                'subtotal' => $subtotal,
                'total' => $subtotal,
            ]);

            foreach ($cart as $productId => $item) {
                $product = $products->get((int) $productId);
                $quantity = (int) $item['quantity'];
                $lineTotal = (float) $product->price * $quantity;

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->translatedName(),
                    'product_sku' => $product->sku,
                    'quantity' => $quantity,
                    'unit_cost' => $product->cost ?? 0.00,
                    'unit_price' => $product->price,
                    'total' => $lineTotal,
                ]);

                $product->decrement('stock', $quantity);
            }

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();

            report($exception);

            return back()
                ->withInput()
                ->withErrors(['checkout' => __('No pudimos procesar la compra. Intentá nuevamente.')]);
        }

        session()->forget('cart');

        return $this->redirectToPaymentGateway($order);
    }

    public function success(Order $order): View
    {
        return view('checkout.success', [
            'order' => $order->load('items.product'),
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

    private function redirectToPaymentGateway(Order $order): RedirectResponse
    {
        if ($order->payment_method === Order::PAYMENT_TRANSFER) {
            return redirect()->route('checkout.success', $order);
        }

        if ($order->payment_method === Order::PAYMENT_MERCADOPAGO) {
            $preference = $this->mercadoPagoService->createPreference($order->load('items'));

            if ($preference['reference'] ?? null) {
                $order->update(['payment_reference' => $preference['reference']]);
            }

            return redirect()->away($preference['redirect_url']);
        }

        return redirect()->route('checkout.success', $order);
    }

    private function cartTotal(array $cart): float
    {
        return array_reduce($cart, function (float $total, array $item): float {
            return $total + ((float) $item['price'] * (int) $item['quantity']);
        }, 0.0);
    }
}
