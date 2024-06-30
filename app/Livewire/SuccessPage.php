<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Success | E-Commerce')] // Livewire Attribute for Changing the Default page title.

class SuccessPage extends Component
{
    public function render()
    {
        // getting the latest order of the current user.
        $user_latest_order = Order::with('address')->where('user_id', auth()->user()->id)->latest()->first();
        
        return view('livewire.success-page',[
            'order' => $user_latest_order,
        ]);
    }
}
