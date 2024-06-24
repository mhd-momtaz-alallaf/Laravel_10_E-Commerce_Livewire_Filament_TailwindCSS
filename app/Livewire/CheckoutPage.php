<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Checkout | E-Commerce')] // Livewire Attribute for Changing the Default page title.

class CheckoutPage extends Component
{
    public function render()
    {
        $cart_items = CartManagement::getCartItemsFromCookie(); // getting the cart items from the cookie.
        $grand_total = CartManagement::calculateCartItemsGrandTotal($cart_items); // getting the grand total of the cart items.

        return view('livewire.checkout-page', [
            'cart_items' => $cart_items, // passing the attributes to the view.
            'grand_total' => $grand_total,
        ]);
    }
}
