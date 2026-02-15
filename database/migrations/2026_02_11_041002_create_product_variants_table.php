<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('sku')->unique();
            $table->string('color_code')->nullable(); // Hex code e.g. #FF0000
            $table->string('size')->nullable(); // e.g. S, M, L, XL, 42, 44
            $table->integer('stock')->default(0);
            $table->decimal('price_modifier', 10, 2)->default(0.00); // Amount to add/subtract from base_price
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
