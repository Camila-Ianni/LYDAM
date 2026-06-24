<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pendiente';
    public const STATUS_PAID = 'pagada';
    public const STATUS_SHIPPED = 'enviada';
    public const STATUS_FAILED = 'fallida';
    public const STATUS_CANCELLED = 'cancelada';

    public const PAYMENT_TRANSFER = 'transferencia';
    public const PAYMENT_MERCADOPAGO = 'mercadopago';
    public const PAYMENT_PAYPAL = 'paypal';

    protected $fillable = [
        'user_id',
        'buyer_name',
        'buyer_dni',
        'buyer_email',
        'buyer_phone',
        'payment_method',
        'payment_reference',
        'status',
        'subtotal',
        'total',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'total' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function markAsPaid(?string $paymentReference = null): void
    {
        $this->forceFill([
            'status' => self::STATUS_PAID,
            'payment_reference' => $paymentReference ?: $this->payment_reference,
            'paid_at' => now(),
        ])->save();
    }
}
