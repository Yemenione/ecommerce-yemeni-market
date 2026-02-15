<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    public function run(): void
    {
        $taxes = [
            ['name' => 'VAT Standard (France)', 'rate' => 20.00, 'is_active' => true],
            ['name' => 'VAT Reduced (France)', 'rate' => 5.50, 'is_active' => true],
            ['name' => 'VAT Standard (Germany)', 'rate' => 19.00, 'is_active' => true],
            ['name' => 'VAT Standard (UK)', 'rate' => 20.00, 'is_active' => true],
            ['name' => 'VAT Standard (Italy)', 'rate' => 22.00, 'is_active' => true],
            ['name' => 'VAT Standard (Spain)', 'rate' => 21.00, 'is_active' => true],
            ['name' => 'VAT Zero (Export)', 'rate' => 0.00, 'is_active' => true],
        ];

        foreach ($taxes as $tax) {
            Tax::create($tax);
        }
    }
}
