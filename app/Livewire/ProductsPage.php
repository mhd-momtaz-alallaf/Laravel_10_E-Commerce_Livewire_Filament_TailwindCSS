<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products | E-Commerce')] // Livewire Attribute for Changing the Default page title.

class ProductsPage extends Component
{
    use WithPagination; // to use pagination with livewire.

    #[Url] // a livewire 3 attribute to get the passed attributes from the view like ($selected_categories) and pass it to the route attributes as url.
    public $selected_categories = []; // to get the selected categories (categories filtering values) from the products_page view.

    public function render()
    {
        $productsQuery = Product::query()->where('is_active', 1); // Getting all active Products form the database.

        if(!empty($this->selected_categories)){ // the final step of getting the filtering by categories, we will add more condition to the productsQuery.
            $productsQuery->whereIn('category_id', $this->selected_categories); // getting only the products of the passed category_id/s.
        }

        $brands = Brand::where('is_active', 1)->get(['id', 'name', 'slug']); // Getting all active Brands form the database.

        $categories = Category::where('is_active', 1)->get(['id', 'name', 'slug']); // Getting all active Categories form the database.

        return view('livewire.products-page', [
            'products' => $productsQuery->paginate(6), // Passing the paginated $products collection to the view.
            'brands' => $brands,
            'categories'=> $categories,
        ]);
    }
}
