<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cart | E-Commerce')] // Livewire Attribute for Changing the Default page title.

class CartPage extends Component
{
    public $cart_items = []; // property for handling the cart items.
    public $grand_total; // property for handling the grand total.

    public function mount()
    {
        $this->cart_items = CartManagement::getCartItemsFromCookie(); // getting the cart items from the getCartItemsFromCookie() function.

        $this->grand_total = CartManagement::calculateCartItemsGrandTotal($this->cart_items); // getting the grand total from the calculateCartItemsGrandTotal() function.
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}
