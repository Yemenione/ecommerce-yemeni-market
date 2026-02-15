<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class ProductPage extends Component
{
    public $slug;
    public $quantity = 1;
    public $selectedVariantId;
    public $avgRating = 0;
    public $approvedReviews = [];

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->loadProductData();
    }

    public function loadProductData()
    {
        $product = Product::where('slug', $this->slug)
            ->where('is_active', true)
            ->with(['category', 'reviews.user', 'variants'])
            ->firstOrFail();
            
        $this->approvedReviews = $product->reviews()->where('is_approved', true)->latest()->get();
        $this->avgRating = $product->reviews()->where('is_approved', true)->avg('rating') ?? 0;
        return $product;
    }

    public function getVariantProperty()
    {
        if (!$this->selectedVariantId) return null;
        return \App\Models\ProductVariant::find($this->selectedVariantId);
    }

    public function getPriceProperty()
    {
        $product = $this->loadProductData();
        $basePrice = $product->base_price;
        
        $variant = $this->variant;
        if ($variant) {
            $basePrice += $variant->price_modifier;
        }
        
        return $basePrice;
    }

    public function addToCart()
    {
        $product = Product::where('slug', $this->slug)->firstOrFail();
        
        $cart = Session::get('cart', []);
        
        $itemKey = $product->id;
        if ($this->selectedVariantId) {
            $itemKey .= '-' . $this->selectedVariantId;
        }

        if (isset($cart[$itemKey])) {
            $cart[$itemKey]['quantity'] += $this->quantity;
        } else {
            $cart[$itemKey] = [
                'id' => $product->id,
                'variant_id' => $this->selectedVariantId,
                'quantity' => $this->quantity,
            ];
        }
        
        Session::put('cart', $cart);
        
        $this->dispatch('cart-updated');
        $this->dispatch('open-cart-drawer');
        $this->dispatch('notify', message: __('Product added to cart!'));
    }

    public function render()
    {
        return view('livewire.product-page', [
            'product' => $this->loadProductData(),
        ]);
    }
}
