<?php

namespace App\Livewire\Partials;

use App\Helpers\CartManagement;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    public $total_count = 0; // define a $total_count property to show the total cart items in the navbar.blade.php file.

    public function mount()
    {
        $this->total_count = count(CartManagement::getCartItemsFromCookie()); // getting the total_count from the getCartItemsFromCookie method, and it will be updated depending on the updateCartCount listener method.
    }

    // listening to the dispatch method to get the $total_count of cart items, the dispatch method will be in the (addToCart function) from the ProductsPage Component and in the (removeItem function) from the CartPage, so the navbar cart $total_count will changed depending on adding or removing products from the cart.
    #[On('update-cart-count')] // 'update-cart-count' is the event name in the dispatch method.
    public function updateCartCount($total_count) // updating the $total_count value of the cart items, depending on the 'update-cart-count' event.
    {
        $this->total_count = $total_count;
    }

    public function render()
    {
        return view('livewire.partials.navbar');
    }
}