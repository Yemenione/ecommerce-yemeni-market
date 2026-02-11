<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartPage extends Component
{
    public $cart = [];

    public function mount()
    {
        $this->cart = Session::get('cart', []);
    }

    public function getCartItemsProperty()
    {
        if (empty($this->cart)) {
            return collect([]);
        }

        $products = Product::whereIn('id', array_keys($this->cart))->get();

        return $products->map(function ($product) {
            $product->quantity = $this->cart[$product->id];
            $product->subtotal = $product->price_eur * $product->quantity;
            return $product;
        });
    }

    public function getTotalProperty()
    {
        return $this->cartItems->sum('subtotal');
    }

    public function increment($id)
    {
        if (isset($this->cart[$id])) {
            $this->cart[$id]++;
            Session::put('cart', $this->cart);
        }
    }

    public function decrement($id)
    {
        if (isset($this->cart[$id]) && $this->cart[$id] > 1) {
            $this->cart[$id]--;
            Session::put('cart', $this->cart);
        }
    }

    public function remove($id)
    {
        if (isset($this->cart[$id])) {
            unset($this->cart[$id]);
            Session::put('cart', $this->cart);
        }
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}
