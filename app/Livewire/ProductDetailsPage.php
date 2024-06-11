<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Product Details | E-Commerce')] // Livewire Attribute for Changing the Default page title.

class ProductDetailsPage extends Component
{
    public $product; // defining a livewire property for getting the product that passed from the route.

    public function mount(Product $product)
    {
        $this->product = $product; // assigning the $product that coming from the route to the component.
    }

    public function render()
    {
        return view('livewire.product-details-page', [
            'product' => $this->product,
        ]);
    }
}
