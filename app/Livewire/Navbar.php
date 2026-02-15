<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Product;

class Navbar extends Component
{
    public $search = '';
    public $cartCount = 0;
    public $wishlistCount = 0;

    protected $listeners = [
        'cart-updated' => 'updateCartCount',
        'wishlist-updated' => 'updateWishlistCount',
        'toggle-wishlist' => 'toggleWishlist'
    ];

    public function mount()
    {
        $this->updateCartCount();
        $this->updateWishlistCount();
    }

    public function updateCartCount()
    {
        $cart = $this->getNormalizedCart();
        $this->cartCount = collect($cart)->sum('quantity');
    }

    private function getNormalizedCart()
    {
        $cart = session()->get('cart', []);
        $normalized = [];
        $changed = false;

        foreach ($cart as $key => $value) {
            if (is_int($value)) {
                $normalized[$key] = [
                    'id' => $key,
                    'variant_id' => null,
                    'quantity' => $value,
                ];
                $changed = true;
            } else {
                $normalized[$key] = $value;
            }
        }

        if ($changed) {
            session()->put('cart', $normalized);
        }

        return $normalized;
    }

    public function updateWishlistCount()
    {
        $wishlist = session()->get('wishlist', []);
        $this->wishlistCount = count($wishlist);
    }

    public function toggleWishlist($productId)
    {
        $wishlist = session()->get('wishlist', []);
        if (in_array($productId, $wishlist)) {
            $wishlist = array_diff($wishlist, [$productId]);
        } else {
            $wishlist[] = $productId;
        }
        session()->put('wishlist', $wishlist);
        $this->updateWishlistCount();
        $this->dispatch('wishlist-updated');
    }

    public function getCartItemsProperty()
    {
        $cart = $this->getNormalizedCart();
        if (empty($cart)) return collect();

        $productIds = collect($cart)->pluck('id')->filter()->unique();
        $products = Product::whereIn('id', $productIds)->with('variants')->get();

        return collect($cart)->map(function ($cartItem) use ($products) {
            $product = $products->firstWhere('id', $cartItem['id']);
            if (!$product) return null;

            $item = clone $product;
            $item->quantity = $cartItem['quantity'];
            $item->variant_id = $cartItem['variant_id'];

            $price = $product->base_price;
            $variant = $product->variants->firstWhere('id', $cartItem['variant_id']);

            if ($variant) {
                $price += $variant->price_modifier;
                $item->variant_name = collect([
                    $variant->color_code ? "Color: {$variant->color_code}" : null,
                    $variant->size ? "Size: {$variant->size}" : null,
                    $variant->weight ? "Weight: {$variant->weight}" : null,
                ])->filter()->implode(', ');
            } else {
                $item->variant_name = null;
            }

            $item->subtotal = $price * $item->quantity;
            return $item;
        })->filter();
    }

    public function getCartTotalProperty()
    {
        return $this->cartItems->sum('subtotal');
    }

    public function getResultsProperty()
    {
        if (strlen($this->search) < 2) return collect();

        return \App\Models\Product::where('name', 'like', '%' . $this->search . '%')
            ->where('is_active', true)
            ->take(5)
            ->get();
    }

    public function removeFromCart($key)
    {
        $cart = $this->getNormalizedCart();
        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
            $this->updateCartCount();
            $this->dispatch('cart-updated');
        }
    }

    public function getCategoriesProperty()
    {
        return \App\Models\Category::whereNotNull('image')
            ->take(4)
            ->get();
    }

    public function render()
    {
        return view('livewire.navbar');
    }
}
