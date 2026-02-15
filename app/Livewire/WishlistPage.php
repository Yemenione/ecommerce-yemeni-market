<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class WishlistPage extends Component
{
    protected $listeners = ['wishlist-updated' => '$refresh'];

    public function getWishlistItemsProperty()
    {
        $wishlist = session()->get('wishlist', []);
        if (empty($wishlist)) return collect();

        return Product::whereIn('id', $wishlist)->get();
    }

    public function removeFromWishlist($productId)
    {
        $wishlist = session()->get('wishlist', []);
        $wishlist = array_diff($wishlist, [$productId]);
        session()->put('wishlist', $wishlist);
        $this->dispatch('wishlist-updated');
    }

    public function addToCart($productId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]++;
        } else {
            $cart[$productId] = 1;
        }
        session()->put('cart', $cart);
        
        $this->dispatch('cart-updated');
        $this->dispatch('open-cart-drawer');
        $this->dispatch('notify', message: __('Product added to cart!'));
    }

    public function render()
    {
        return view('livewire.wishlist-page')->layout('components.layouts.app');
    }
}
