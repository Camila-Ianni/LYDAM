<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('admin.orders.index', [
            'orders' => Order::query()
                ->with('user')
                ->latest()
                ->paginate(20),
            'statuses' => $this->statuses(),
        ]);
    }

    public function show(Order $order): View
    {
        return view('admin.orders.show', [
            'order' => $order->load(['user', 'items.product']),
            'statuses' => $this->statuses(),
        ]);
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys($this->statuses()))],
        ]);

        $updates = ['status' => $data['status']];

        if ($data['status'] === Order::STATUS_PAID && ! $order->paid_at) {
            $updates['paid_at'] = now();
        }

        $order->update($updates);

        return back()->with('status', __('Estado de la orden actualizado.'));
    }

    public function salesDashboard(): View
    {
        $orders = Order::whereIn('status', [Order::STATUS_PAID, Order::STATUS_SHIPPED])
            ->with('items.product')
            ->get();
        
        $productSales = [];
        $totalSalesSum = 0;
        
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $productId = $item->product_id;
                $productName = $item->product ? $item->product->translatedName('es') : ($item->name ?? 'Producto Eliminado');
                $quantity = (int) $item->quantity;
                $subtotal = (float) $item->price * $quantity;
                
                if (!isset($productSales[$productId])) {
                    $productSales[$productId] = [
                        'name' => $productName,
                        'sku' => $item->sku,
                        'quantity' => 0,
                        'total' => 0,
                    ];
                }
                
                $productSales[$productId]['quantity'] += $quantity;
                $productSales[$productId]['total'] += $subtotal;
                $totalSalesSum += $subtotal;
            }
        }
        
        return view('admin.sales.dashboard', [
            'productSales' => collect($productSales)->sortByDesc('total'),
            'totalSalesSum' => $totalSalesSum,
        ]);
    }

    private function statuses(): array
    {
        return [
            Order::STATUS_PENDING => __('Pendiente'),
            Order::STATUS_PAID => __('Pagada'),
            Order::STATUS_SHIPPED => __('Enviada'),
            Order::STATUS_FAILED => __('Fallida'),
            Order::STATUS_CANCELLED => __('Cancelada'),
        ];
    }
}
