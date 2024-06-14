<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cart | E-Commerce')] // Livewire Attribute for Changing the Default page title.

class CartPage extends Component
{
    use LivewireAlert; // to use the livewire-alert-SweetAlert2 Package (Removed from cart alert message).

    public $cart_items = []; // property for handling the cart items.
    public $grand_total; // property for handling the grand total.

    public function mount()
    {
        $this->cart_items = CartManagement::getCartItemsFromCookie(); // getting the cart items from the getCartItemsFromCookie() function.

        $this->grand_total = CartManagement::calculateCartItemsGrandTotal($this->cart_items); // getting the grand total from the calculateCartItemsGrandTotal() function.
    }

    public function removeItem($product_id) // This function is for Removing a product from the cart.
    {
        $this->cart_items = CartManagement::removeCartItem($product_id); // Remove the cart item(product) by the removeCartItem() function.
     
        $this->grand_total = CartManagement::calculateCartItemsGrandTotal($this->cart_items); // getting the grand total after removing the product by the calculateCartItemsGrandTotal() function.

        // After Removing the Item From the Cart we have to update the navbar cart items count, getting the $total_count from count($this->cart_items), and we will send it to the Navbar component to show the user how many items last in his cart, by the ->dispatch method.
        $this->dispatch('update-cart-count', total_count: count($this->cart_items))->to(Navbar::class); // 'update-cart-count' is the name of the event, 'total_count' is the data that will send with the event to the Navbar component, and we will listen to this event in the Navbar Component.

        $this->alert('success', 'Product Removed From the Cart Successfully!', [ // Showing a Success Massage after removing the product from the cart via livewire-alert-SweetAlert2 Package.
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function increaseQuantity($product_id) // this method is for handling the pressing event on the (Plus Button) in the view and increase the Quantity of the product by 1.
    {
        $this->cart_items = CartManagement::incrementQuantityOfCartItem($product_id); // incrementing the quantity of the item by the method incrementQuantityOfCartItem().

        $this->grand_total = CartManagement::calculateCartItemsGrandTotal($this->cart_items); // re calculate the grand_total after increasing the quantity.
    }

    public function decreaseQuantity($product_id)  // this method is for handling the pressing event on the (Minus Button) in the view and decrease the Quantity of the product by 1.
    {
        $this->cart_items = CartManagement::decrementQuantityOfCartItem($product_id); // decrementing the quantity of the item by the method incrementQuantityOfCartItem().

        $this->grand_total = CartManagement::calculateCartItemsGrandTotal($this->cart_items); // re calculate the grand_total after decreasing the quantity.
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}
