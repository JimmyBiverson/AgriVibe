<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marketplace_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 30)->unique();
            $table->foreignId('buyer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('marketplace_item_id')->nullable()->constrained('marketplace_items')->nullOnDelete();

            $table->string('item_title', 200);
            $table->decimal('quantity', 10, 2)->default(1);
            $table->string('unit', 30)->nullable();
            $table->decimal('unit_price', 12, 2);
            $table->string('currency', 3)->default('UGX');
            $table->decimal('total_amount', 14, 2);

            $table->decimal('amount_paid', 14, 2)->default(0);
            $table->string('payment_status', 20)->default('unpaid'); // unpaid, partial, paid
            $table->string('payment_method', 40)->nullable(); // cash, mobile_money, bank_transfer
            $table->string('payment_reference', 100)->nullable();

            $table->string('status', 20)->default('pending'); // pending, confirmed, dispatched, delivered, completed, cancelled, disputed
            $table->string('delivery_method', 40)->nullable(); // pickup, delivery, courier
            $table->string('delivery_address', 255)->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('dispatched_at')->nullable();
            $table->timestamp('delivered_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['seller_id', 'status']);
            $table->index(['buyer_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketplace_orders');
    }
};
