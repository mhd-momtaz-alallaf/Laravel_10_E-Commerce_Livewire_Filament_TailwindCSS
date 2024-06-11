<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products | E-Commerce')] // Livewire Attribute for Changing the Default page title.

class ProductsPage extends Component
{
    use WithPagination; // to use pagination with livewire.

    public function render()
    {
        $productsQuery = Product::query()->where('is_active', 1); // Getting all active Products form the database.

        $categories = Category::where('is_active', 1)->get(['id', 'name', 'slug']); // Getting all active Categories form the database.

        return view('livewire.products-page', [
            'products' => $productsQuery->paginate(6), // Passing the paginated $products collection to the view.
            'categories'=> $categories,
        ]);
    }
}
