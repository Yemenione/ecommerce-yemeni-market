<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use Illuminate\Database\Seeder;

class ShippingMethodSeeder extends Seeder
{
    public function run(): void
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        ShippingMethod::query()->delete();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $methods = [
            // France Zone
            [
                'name' => 'Colissimo Domicile (France)',
                'zone' => 'france',
                'price' => 7.50,
                'min_order_amount' => 150.00, // Free over 150€
                'is_active' => true,
            ],
            [
                'name' => 'Colissimo Point Retrait (France)',
                'zone' => 'france',
                'price' => 4.90,
                'min_order_amount' => 100.00,
                'is_active' => true,
            ],
            [
                'name' => 'Mondial Relay (France)',
                'zone' => 'france',
                'price' => 3.95,
                'min_order_amount' => 75.00,
                'is_active' => true,
            ],
            [
                'name' => 'Chronopost 24h (France)',
                'zone' => 'france',
                'price' => 14.90,
                'min_order_amount' => 300.00,
                'is_active' => true,
            ],

            // Europe Zone
            [
                'name' => 'DHL Express Europe',
                'zone' => 'europe',
                'price' => 19.00,
                'min_order_amount' => 500.00,
                'is_active' => true,
            ],
            [
                'name' => 'Standard EU Shipping',
                'zone' => 'europe',
                'price' => 12.00,
                'min_order_amount' => 200.00,
                'is_active' => true,
            ],

            // World Zone
            [
                'name' => 'International Priority (World)',
                'zone' => 'world',
                'price' => 35.00,
                'min_order_amount' => 1000.00,
                'is_active' => true,
            ],
        ];

        foreach ($methods as $method) {
            ShippingMethod::create($method);
        }
    }
}
