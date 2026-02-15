<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class QuickView extends Component
{
    public $product = null;
    public $show = false;
    public $quantity = 1;

    protected $listeners = ['open-quick-view' => 'loadProduct'];

    public function loadProduct($productId)
    {
        $this->product = Product::find($productId);
        $this->quantity = 1;
        $this->show = true;
    }

    public function addToCart()
    {
        if (!$this->product) return;

        $cart = Session::get('cart', []);
        if (isset($cart[$this->product->id])) {
            $cart[$this->product->id] += $this->quantity;
        } else {
            $cart[$this->product->id] = $this->quantity;
        }
        Session::put('cart', $cart);

        $this->show = false;
        $this->dispatch('cart-updated');
        $this->dispatch('open-cart-drawer');
        $this->dispatch('notify', message: __('Product added to cart!'));
    }

    public function close()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.quick-view');
    }
}
