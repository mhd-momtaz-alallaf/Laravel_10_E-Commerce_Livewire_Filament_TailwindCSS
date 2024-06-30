<?php

namespace App\Livewire;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Attributes\Title;
use Livewire\Component;
#[Title('Order Details | E-Commerce')] // Livewire Attribute for Changing the Default page title.

class MyOrderDetailsPage extends Component
{
    // defining a livewire property to get the order_id that passed from the route (/my-orders/{order_id}).
    public $order_id;

    public function mount($order_id)
    {
        $this->order_id = $order_id;
    }

    public function render()
    {
        $order = Order::where('order_id', $this->order_id)->first();
        $order_items = OrderItem::with('product')->where('order_id', $this->order_id)->get();
        $order_address = Address::where('order_id', $this->order_id)->first();

        return view('livewire.my-order-details-page', [
            'order' => $order,
            'order_items' => $order_items,
            'order_address' => $order_address,
        ]);
    }
}
