<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Rename price_eur to base_price if it exists, otherwise create base_price
            if (Schema::hasColumn('products', 'price_eur')) {
                $table->renameColumn('price_eur', 'base_price');
            } else {
                $table->decimal('base_price', 10, 2)->after('description');
            }

            $table->string('slug')->unique()->after('name')->nullable();
            $table->boolean('is_flash_sale')->default(false)->after('images');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'base_price')) {
                $table->renameColumn('base_price', 'price_eur');
            }
            $table->dropColumn(['slug', 'is_flash_sale']);
        });
    }
};
