<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Session;

class ShopPage extends Component
{
    use WithPagination;

    public $selectedCategories = [];
    public $minPrice = 0;
    public $maxPrice = 1000;
    public $sort = 'latest';

    public function addToCart($productId)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]++;
        } else {
            $cart[$productId] = 1;
        }
        Session::put('cart', $cart);
        
        $this->dispatch('cart-updated'); // Optional, if I add listener later
    }

    public function updatingSelectedCategories()
    {
        $this->resetPage();
    }

    public function updatingMinPrice()
    {
        $this->resetPage();
    }

    public function updatingMaxPrice()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::query()
            ->when($this->selectedCategories, function ($query) {
                $query->whereIn('category_id', $this->selectedCategories);
            })
            ->whereBetween('price_eur', [$this->minPrice, $this->maxPrice])
            ->when($this->sort === 'price_low', function ($query) {
                $query->orderBy('price_eur', 'asc');
            })
            ->when($this->sort === 'price_high', function ($query) {
                $query->orderBy('price_eur', 'desc');
            })
            ->when($this->sort === 'latest', function ($query) {
                $query->latest();
            })
            ->paginate(12);

        return view('livewire.shop-page', [
            'products' => $products,
            'categories' => Category::all(),
        ]);
    }
}
