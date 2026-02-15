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
    public $shippingCost = 0;
    public $total = 0;
    public $shippingMethodId;
    public $availableShippingMethods = [];
    public $taxTotal = 0;
    public $totalWithTax = 0;

    // Form fields
    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    public $address;
    public $city;
    public $zip;
    public $country = 'France'; // Default
    public $paymentMethod = 'stripe'; // Default
    
    // Stripe specific
    public $clientSecret;
    public $stripePublicKey;

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
        'shippingMethodId' => 'required',
    ];

    public function mount(\App\Settings\PaymentSettings $paymentSettings)
    {
        $this->cart = $this->getNormalizedCart();
        if (empty($this->cart)) {
            return redirect()->route('shop');
        }

        $productIds = collect($this->cart)->pluck('id')->unique();
        $products = Product::whereIn('id', $productIds)->with('variants')->get();
        
        $this->items = collect($this->cart)->map(function ($cartItem) use ($products) {
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

            $item->final_price = $price;
            $item->subtotal = $price * $item->quantity;
            $item->load('tax');
            return $item;
        })->filter();

        $this->updateShippingMethods();
        $this->calculateTotal();
        
        if ($paymentSettings->stripe_enabled) {
            $this->stripePublicKey = $paymentSettings->stripe_public_key;
            $this->createPaymentIntent($paymentSettings);
        }
    }

    public function updatedCountry()
    {
        $this->updateShippingMethods();
        $this->calculateTotal();
    }

    public function updatedShippingMethodId()
    {
        $this->calculateTotal();
    }

    public function updateShippingMethods()
    {
        // Define zone based on country
        $zone = 'world';
        if ($this->country === 'France') {
            $zone = 'france';
        } elseif ($this->country === 'Germany') {
            $zone = 'germany';
        } elseif (in_array($this->country, ['Belgium', 'Italy', 'Spain', 'Netherlands', 'Austria'])) { // Add more EU countries
             $zone = 'europe';
        }

        $this->availableShippingMethods = \App\Models\ShippingMethod::where('is_active', true)
            ->where(function($query) use ($zone) {
                $query->where('zone', $zone)
                      ->orWhere('zone', 'world');
            })
            ->get();
            
        // Reset selected method if not in available lists
        if (!$this->availableShippingMethods->contains('id', $this->shippingMethodId)) {
            $this->shippingMethodId = $this->availableShippingMethods->first()->id ?? null;
        }
    }

    public function createPaymentIntent(\App\Settings\PaymentSettings $paymentSettings)
    {
        if (!$paymentSettings->stripe_secret_key) return;

        \Stripe\Stripe::setApiKey($paymentSettings->stripe_secret_key);

        try {
            $intent = \Stripe\PaymentIntent::create([
                'amount' => round($this->total * 100), // Amount in cents
                'currency' => 'eur',
                'metadata' => [
                    'email' => $this->email,
                    'customer_name' => $this->firstName . ' ' . $this->lastName,
                ],
            ]);

            $this->clientSecret = $intent->client_secret;
        } catch (\Exception $e) {
            // Log or handle error
        }
    }

    public function calculateTotal()
    {
        $subtotal = $this->items->sum('subtotal');
        
        $shippingMethod = $this->availableShippingMethods->firstWhere('id', $this->shippingMethodId);
        
        if ($shippingMethod) {
            if ($shippingMethod->min_order_amount && $subtotal >= $shippingMethod->min_order_amount) {
                $this->shippingCost = 0;
            } else {
                $this->shippingCost = $shippingMethod->price;
            }
        } else {
            $this->shippingCost = 0;
        }

        $this->taxTotal = $this->items->reduce(function ($carry, $item) {
            $rate = $item->tax?->rate ?? 0;
            return $carry + (($item->subtotal * $rate) / 100);
        }, 0);

        $this->totalWithTax = $subtotal + $this->shippingCost + $this->taxTotal;
        $this->total = $this->totalWithTax;

        // Re-create intent if total changes and Stripe is enabled
        $paymentSettings = app(\App\Settings\PaymentSettings::class);
        if ($this->paymentMethod === 'stripe' && $paymentSettings->stripe_enabled) {
            $this->createPaymentIntent($paymentSettings);
        }
    }

    public function placeOrder($stripePaymentId = null)
    {
        $this->validate();

        if ($this->paymentMethod === 'stripe' && !$stripePaymentId) {
            $this->addError('payment', 'Payment processing error.');
            return;
        }

        $shippingMethod = $this->availableShippingMethods->firstWhere('id', $this->shippingMethodId);

        $orderData = [
            'user_id' => auth()->id(),
            'subtotal_eur' => $this->items->sum('subtotal'),
            'shipping_cost' => $this->shippingCost,
            'shipping_method_name' => $shippingMethod ? $shippingMethod->name : 'Standard',
            'total_eur' => $this->total,
            'status' => $this->paymentMethod === 'stripe' ? \App\Enums\OrderStatus::Processing : \App\Enums\OrderStatus::Pending,
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
                    'variant_id' => $item->variant_id,
                    'name' => $item->name . ($item->variant_name ? " ({$item->variant_name})" : ""),
                    'price' => $item->final_price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                ];
            })->toArray(),
        ];

        if ($stripePaymentId) {
            $orderData['stripe_payment_id'] = $stripePaymentId;
        }

        $order = Order::create($orderData);

        Session::forget('cart');

        try {
            // Send email to Customer
            \Illuminate\Support\Facades\Mail::to($order->user ?? $this->email)->send(new \App\Mail\OrderPlaced($order));
            
            // Send email to Admin
            $adminEmail = $this->getAdminEmail();
            if ($adminEmail) {
                \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\OrderPlaced($order));
            }
        } catch (\Exception $e) {
            // Log error, but don't fail the order
            \Illuminate\Support\Facades\Log::error('Order email failed: ' . $e->getMessage());
        }

        session()->flash('success', 'Order placed successfully!');
        
        return redirect()->route('success', $order);
    }

    public function validateForm()
    {
        $this->validate();
        return true;
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

    public function getAdminEmail()
    {
        try {
           $settings = app(\App\Settings\GeneralSettings::class);
           return $settings->support_email ?? env('MAIL_FROM_ADDRESS'); 
        } catch (\Exception $e) {
            return env('MAIL_FROM_ADDRESS');
        }
    }

    public function render()
    {
        return view('livewire.checkout-page');
    }
}
