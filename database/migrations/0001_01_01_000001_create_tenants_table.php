<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('payment_tenant', function (Blueprint $table) {
            $table->foreignUuid('payment_id')->index()->cascadeOnDelete();
            $table->foreignUuid('tenant_id')->index()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_tenant');
        Schema::dropIfExists('tenants');
    }
};
