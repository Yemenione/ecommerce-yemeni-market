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
        
        $this->dispatch('cart-updated');
        $this->dispatch('open-cart-drawer');
    }

    public function render()
    {
        $banners = \App\Models\Banner::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $categories = \App\Models\Category::has('products')->whereNotNull('image')
            ->take(10)
            ->get();
        
        // Fallback if no categories have images yet, fetch generic ones
        if ($categories->isEmpty()) {
             $categories = \App\Models\Category::has('products')->take(10)->get();
        }

        $flashSales = \App\Models\FlashSale::where('is_active', true)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->whereHas('product', fn($q) => $q->where('is_active', true))
            ->with(['product'])
            ->get();

        return view('livewire.landing-page', [
            'banners' => $banners,
            'categories' => $categories,
            'flashSales' => $flashSales,
            'newArrivals' => Product::where('is_active', true)->latest()->take(8)->get(),
            'bestSellers' => Product::where('is_active', true)->orderByDesc('sold_count')->take(8)->get(),
        ]);
    }
}
