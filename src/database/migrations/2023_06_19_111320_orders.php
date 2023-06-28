<?php

use App\Enums\OrderStatus;
use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('total_amount')->nullable();
            $table->string('receipt', 255)->nullable();
            $table->string('mode_of_payment', 255)->default(PaymentMode::COD->value)->nullable();
            $table->string('order_status', 255)->default(OrderStatus::PLACED->value)->nullable();
            $table->string('payment_status', 255)->default(PaymentStatus::PENDING->value)->nullable();
            $table->string('razorpay_signature', 255)->nullable();
            $table->text('razorpay_order_id')->nullable();
            $table->text('razorpay_payment_id')->nullable();
            $table->timestamp('placed_at', 0)->useCurrent()->nullable();
            $table->timestamp('packed_at', 0)->nullable();
            $table->timestamp('shipped_at', 0)->nullable();
            $table->timestamp('ofd_at', 0)->nullable();
            $table->timestamp('delivered_at', 0)->nullable();
            $table->timestamp('cancelled_at', 0)->nullable();
            $table->foreignId('address_id')->nullable()->constrained('addresses')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
