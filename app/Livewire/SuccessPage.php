<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;

class SuccessPage extends Component
{
    public $order;

    public function mount($order)
    {
        $this->order = Order::findOrFail($order);

        if (auth()->check() && $this->order->user_id !== auth()->id()) {
            abort(403);
        }
    }

    public function render()
    {
        return view('livewire.success-page');
    }
}
