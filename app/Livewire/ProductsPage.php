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

    #[Url] // a livewire 3 attribute to get the passed ($selected_categories) value from the view and it will pass it to the url route attributes.
    public $selected_categories = []; // to get the selected categories (categories filtering values) from the products_page view.

    #[Url] // getting the passed ($selected_brands) value from the view and passing it to the url route attributes.
    public $selected_brands = []; // to get the selected brands (Brands filtering values) from the products_page view.

    public function render()
    {
        $productsQuery = Product::query()->where('is_active', 1); // Getting all active Products form the database.

        if(!empty($this->selected_categories)){ // getting the filtering by categories, we will add more condition to the productsQuery.
            $productsQuery->whereIn('category_id', $this->selected_categories); // getting only the products of the passed category_id/s.
        }

        if(!empty($this->selected_brands)){ // getting the filtering by brands, we will add more condition to the productsQuery.
            $productsQuery->whereIn('brand_id', $this->selected_brands); // getting only the products of the passed brand_id/s.
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
