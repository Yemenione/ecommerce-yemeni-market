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
    public $search = '';

    protected $queryString = [
        'selectedCategories' => ['except' => []],
        'minPrice' => ['except' => 0],
        'maxPrice' => ['except' => 1000],
        'sort' => ['except' => 'latest'],
        'search' => ['except' => ''],
    ];

    public function addToCart($productId)
    {
        $cart = Session::get('cart', []);
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
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedCategories, function ($query) {
                $query->whereIn('category_id', $this->selectedCategories);
            })
            ->whereBetween('base_price', [$this->minPrice, $this->maxPrice])
            ->when($this->sort === 'price_low', function ($query) {
                $query->orderBy('base_price', 'asc');
            })
            ->when($this->sort === 'price_high', function ($query) {
                $query->orderBy('base_price', 'desc');
            })
            ->when($this->sort === 'latest', function ($query) {
                $query->latest();
            })
            ->paginate(12);

        return view('livewire.shop-page', [
            'products' => $products,
            'categories' => Category::has('products')->get(),
        ]);
    }
}
