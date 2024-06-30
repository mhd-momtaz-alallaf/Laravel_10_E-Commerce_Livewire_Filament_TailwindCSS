<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('My Orders | E-Commerce')] // Livewire Attribute for Changing the Default page title.

class MyOrdersPage extends Component
{
    // using WithPagination Trait to have be able to use ->paginate() in the queries inside the livewire component.
    use WithPagination; 

    public function render()
    {
        $my_orders = Order::where('user_id', auth()->user()->id)->latest()->paginate(2);

        return view('livewire.my-orders-page',[
            'orders' => $my_orders,
        ]);
    }
}
