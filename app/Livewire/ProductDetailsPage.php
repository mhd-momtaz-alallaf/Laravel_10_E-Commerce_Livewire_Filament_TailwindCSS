<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Product Details | E-Commerce')] // Livewire Attribute for Changing the Default page title.

class ProductDetailsPage extends Component
{
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

    public function render()
    {
        return view('livewire.product-details-page', [
            'product' => $this->product,
        ]);
    }
}
