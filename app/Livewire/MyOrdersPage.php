<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;

class MyOrdersPage extends Component
{
    use WithPagination;

    public function render()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->paginate(5);
        return view('livewire.my-orders-page', [
            'orders' => $orders,
        ]);
    }
}
