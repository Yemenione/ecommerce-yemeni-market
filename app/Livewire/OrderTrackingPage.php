<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Order Tracking - Yemeni Market')]
class OrderTrackingPage extends Component
{
    public $order_id;
    public $email;
    public $order;
    public $errorMessage;

    public function trackOrder()
    {
        $this->validate([
            'order_id' => 'required', // Assuming order ID is numeric
            'email' => 'required|email',
        ]);

        $this->order = Order::where('id', $this->order_id)
            ->whereHas('user', function ($query) {
                $query->where('email', $this->email);
            })
            ->orWhere(function ($query) {
                // Also check guest orders if email is stored directly on order or in address json
                $query->where('id', $this->order_id)
                      ->whereJsonContains('shipping_address->email', $this->email);
            })
            ->first();

        if (!$this->order) {
            $this->errorMessage = 'Order not found with the provided details.';
            $this->order = null;
        } else {
            $this->errorMessage = null;
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.order-tracking-page');
    }
}
