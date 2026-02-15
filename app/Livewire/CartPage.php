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
        $this->cart = $this->getNormalizedCart();
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

    public function getCartItemsProperty()
    {
        if (empty($this->cart)) {
            return collect([]);
        }

        $productIds = collect($this->cart)->pluck('id')->filter()->unique();
        $products = Product::whereIn('id', $productIds)->with('variants')->get();

        return collect($this->cart)->map(function ($cartItem, $key) use ($products) {
            $product = $products->firstWhere('id', $cartItem['id']);
            if (!$product) return null;

            $item = clone $product;
            $item->cart_key = $key;
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

            $item->final_price = $price;
            $item->subtotal = $price * $item->quantity;
            return $item;
        })->filter();
    }

    public function getTotalProperty()
    {
        return $this->cartItems->sum('subtotal');
    }

    public function increment($key)
    {
        if (isset($this->cart[$key])) {
            $this->cart[$key]['quantity']++;
            Session::put('cart', $this->cart);
        }
    }

    public function decrement($key)
    {
        if (isset($this->cart[$key]) && $this->cart[$key]['quantity'] > 1) {
            $this->cart[$key]['quantity']--;
            Session::put('cart', $this->cart);
        }
    }

    public function remove($key)
    {
        if (isset($this->cart[$key])) {
            unset($this->cart[$key]);
            Session::put('cart', $this->cart);
            $this->dispatch('cart-updated');
        }
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}
