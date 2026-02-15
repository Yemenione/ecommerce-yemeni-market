<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal_eur', 10, 2)->after('user_id');
            $table->decimal('shipping_cost', 10, 2)->default(0)->after('subtotal_eur');
            $table->string('shipping_method_name')->nullable()->after('payment_method');
            // Make user_id nullable for guest checkout
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['subtotal_eur', 'shipping_cost', 'shipping_method_name']);
            // Reverting nullable user_id might fail if nulls exist
        });
    }
};
