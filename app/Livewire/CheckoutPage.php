<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CheckoutPage extends Component
{
    public $cart = [];
    public $items = [];
    public $total = 0;

    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    public $address;
    public $city;
    public $zip;
    public $country = 'France';
    public $paymentMethod = 'stripe';

    protected $rules = [
        'firstName' => 'required',
        'lastName' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'address' => 'required',
        'city' => 'required',
        'zip' => 'required',
        'country' => 'required',
        'paymentMethod' => 'required',
    ];

    public function mount()
    {
        $this->cart = Session::get('cart', []);
        if (empty($this->cart)) {
            return redirect()->route('shop');
        }

        $products = Product::whereIn('id', array_keys($this->cart))->get();
        $this->items = $products->map(function ($product) {
            $product->quantity = $this->cart[$product->id];
            $product->subtotal = $product->price_eur * $product->quantity;
            return $product;
        });

        $this->total = $this->items->sum('subtotal');
    }

    public function placeOrder()
    {
        $this->validate();

        $order = Order::create([
            'user_id' => auth()->id(), // Nullable now
            'total_eur' => $this->total,
            'status' => 'pending',
            'payment_method' => $this->paymentMethod,
            'shipping_address' => [
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'city' => $this->city,
                'zip' => $this->zip,
                'country' => $this->country,
            ],
            'items' => $this->items->map(function($item) {
                return [
                    'product_id' => $item->id,
                    'name' => $item->name,
                    'price' => $item->price_eur,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                ];
            })->toArray(),
        ]);

        Session::forget('cart');

        // Here we would integrate Stripe PaymentIntent creation
        // For now, redirect to success
        session()->flash('success', 'Order placed successfully! Order ID: ' . $order->id);
        
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.checkout-page');
    }
}
