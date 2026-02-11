<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use App\Livewire\CartPage;
use Livewire\Livewire;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_page_can_be_rendered()
    {
        $response = $this->get('/cart');
        $response->assertStatus(200);
    }

    public function test_product_can_be_added_to_cart_via_session()
    {
        $product = Product::factory()->create();

        Session::put('cart', [$product->id => 1]);

        Livewire::test(CartPage::class)
            ->assertSee($product->name)
            ->assertSee(number_format($product->price_eur, 2));
    }

    public function test_cart_item_quantity_can_be_updated()
    {
        $product = Product::factory()->create();
        Session::put('cart', [$product->id => 1]);

        Livewire::test(CartPage::class)
            ->call('increment', $product->id)
            ->assertSet('cart', [$product->id => 2]);
    }

    public function test_cart_item_can_be_removed()
    {
        $product = Product::factory()->create();
        Session::put('cart', [$product->id => 1]);

        Livewire::test(CartPage::class)
            ->call('remove', $product->id)
            ->assertSet('cart', []);
    }
}
