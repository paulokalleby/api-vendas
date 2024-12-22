<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tenant_id')->index()->cascadeOnDelete();
            $table->foreignUuid('user_id')->index()->cascadeOnDelete();
            $table->foreignUuid('customer_id')->index()->cascadeOnDelete();
            $table->foreignUuid('payment_id')->index()->cascadeOnDelete();
            $table->integer('identify');
            $table->string('status')->default('Open');
            $table->timestamps();
        });

        Schema::create('order_product', function (Blueprint $table) {
            $table->id()->primary();
            $table->foreignUuid('order_id')->index()->cascadeOnDelete();
            $table->foreignUuid('product_id')->index()->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->double('price', 10, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_product');
        Schema::dropIfExists('orders');
    }
};
