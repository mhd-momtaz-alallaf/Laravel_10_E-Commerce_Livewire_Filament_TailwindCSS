<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Product Details | E-Commerce')] // Livewire Attribute for Changing the Default page title.

class ProductDetailsPage extends Component
{
    use LivewireAlert; // to use the livewire-alert-SweetAlert2 Package (Added to cart alert message).

    public $quantity = 1; // defining a livewire property for showing the quantity in the view.
    public $product; // defining a livewire property for getting the product that passed from the route.

    public function mount(Product $product)
    {
        $this->product = $product; // assigning the $product that coming from the route to the component.
    }

    public function increaseQuantity() // this method is for handling the pressing event on the (Plus Button) in the view and increase the Quantity of the product by 1.
    {
        $this->quantity++;
    }

    public function decreaseQuantity()  // this method is for handling the pressing event on the (Minus Button) in the view and decrease the Quantity of the product by 1.
    {
        if ($this->quantity > 1) { // to avoid getting a negative quantity.
            $this->quantity--;
        }
    }

    public function addToCart($product_id)// this function will be called only when the event AddToCart is triggered via clicking the button 'Add to Cart' in the product-details-page.blade.php .
    {
        $total_count = CartManagement::addItemToCartWithQuantity($product_id, $this->quantity); // adding the product with the wanted quantity to the cart via addItemToCartWithQuantity function that returns the total count of cart items.
        
        // after getting the $total_count of cart items, we will send it to the Navbar component to show the user how many items in his cart, by ->dispatch method.
        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class); // 'update-cart-count' is the name of the event, 'total_count' is the data that will send with the event to the Navbar component, and we will listen to this event in the Navbar Component.

        $this->alert('success', 'Product Added to the Cart Successfully!', [ // Showing a Success Massage after adding the product to the cart via livewire-alert-SweetAlert2 Package.
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.product-details-page', [
            'product' => $this->product,
        ]);
    }
}
