<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('buyer_name');
            $table->string('buyer_dni', 20);
            $table->string('buyer_email');
            $table->string('buyer_phone', 30);
            $table->string('payment_method', 30);
            $table->string('payment_reference')->nullable()->index();
            $table->string('status', 30)->default('pendiente')->index();
            $table->decimal('subtotal', 12, 2);
            $table->decimal('total', 12, 2);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['payment_method', 'status']);
            $table->index(['buyer_email', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
