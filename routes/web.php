<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::get('/lang/{locale}', [LocaleController::class, 'switch'])
    ->whereIn('locale', ['es', 'en'])
    ->name('locale.switch');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
Route::get('/productos/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::prefix('carrito')->name('cart.')->group(function (): void {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/agregar/{product}', [CartController::class, 'add'])->name('add');
    Route::patch('/items/{product}', [CartController::class, 'update'])->name('update');
    Route::delete('/items/{product}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/vaciar', [CartController::class, 'clear'])->name('clear');
});

Route::prefix('checkout')->name('checkout.')->group(function (): void {
    Route::get('/', [CheckoutController::class, 'create'])->name('create');
    Route::post('/', [CheckoutController::class, 'store'])->name('store');
    Route::get('/exito/{order}', [CheckoutController::class, 'success'])->name('success');
    Route::get('/pendiente', [CheckoutController::class, 'pending'])->name('pending');
    Route::get('/fallo', [CheckoutController::class, 'failure'])->name('failure');
});

Route::prefix('pagos/mercadopago')->name('payments.mercadopago.')->group(function (): void {
    Route::get('/success', [MercadoPagoController::class, 'success'])->name('success');
    Route::get('/pending', [MercadoPagoController::class, 'pending'])->name('pending');
    Route::get('/failure', [MercadoPagoController::class, 'failure'])->name('failure');
    Route::post('/webhook', [MercadoPagoController::class, 'webhook'])
        ->withoutMiddleware([VerifyCsrfToken::class])
        ->name('webhook');
});

Route::prefix('pagos/paypal')->name('payments.paypal.')->group(function (): void {
    Route::get('/approve/{order}', [PayPalController::class, 'approve'])->name('approve');
    Route::get('/capture/{order}', [PayPalController::class, 'capture'])->name('capture');
    Route::get('/cancel/{order}', [PayPalController::class, 'cancel'])->name('cancel');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::resource('products', AdminProductController::class);

        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    });

require __DIR__.'/auth.php';
