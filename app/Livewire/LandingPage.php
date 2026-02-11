<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class LandingPage extends Component
{
    public function addToCart($productId)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]++;
        } else {
            $cart[$productId] = 1;
        }
        Session::put('cart', $cart);
    }

    public function render()
    {
        return view('livewire.landing-page', [
            'featuredProducts' => Product::where('is_featured', true)->take(4)->get(),
        ]);
    }
}
