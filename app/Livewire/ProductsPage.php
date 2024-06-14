<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products | E-Commerce')] // Livewire Attribute for Changing the Default page title.

class ProductsPage extends Component
{
    use WithPagination; // to use pagination with livewire.
    use LivewireAlert; // to use the livewire-alert-SweetAlert2 Package (Added to cart alert message).

    #[Url] // a livewire 3 attribute to get the passed ($selected_categories) value from the view and it will pass it to the url route attributes.
    public $selected_categories = []; // to get the selected categories (categories filtering values) from the products_page view.

    #[Url] // getting the passed ($selected_brands) value from the view and passing it to the url route attributes.
    public $selected_brands = []; // to get the selected brands (Brands filtering values) from the products_page view.

    #[Url] // getting the passed ($featured) value from the view and passing it to the url route attributes.
    public $featured = []; // to get the selected 'featured products' status value(Status filtering values) from the products_page view.

    #[Url] // getting the passed ($on_sale) value from the view and passing it to the url route attributes.
    public $on_sale = []; // to get the selected 'On Sale' status value (Status filtering values) from the products_page view.
   
    #[Url] // getting the passed ($price_range) value from the view and passing it to the url route attributes.
    public $max_price_range = 50000; // to get the max_price_range value (Price filtering values) from the products_page view, default value is 50000.
   
    #[Url] // getting the passed ($sort_by) value from the view and passing it to the url route attributes.
    public $sort_by = 'latest'; // to get the sort_by value (sorting values) from the products_page view, default value is 'latest'.

    public function addToCart($product_id)// this function will be called only when the event AddToCart is triggered via clicking the button 'Add to Cart' in the products-page.blade.php .
    {
        $total_count = CartManagement::addItemToCart($product_id); // adding the product to the cart via addItemToCart function that returns the total count of cart items.
        
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
        $productsQuery = Product::query()->where('is_active', 1); // Getting all active Products form the database.

        if(!empty($this->selected_categories)){ // getting the filtering by categories, we will add more condition to the productsQuery.
            $productsQuery->whereIn('category_id', $this->selected_categories); // getting only the products of the passed category_id/s.
        }

        if(!empty($this->selected_brands)){ // getting the filtering by brands, we will add more condition to the productsQuery.
            $productsQuery->whereIn('brand_id', $this->selected_brands); // getting only the products of the passed brand_id/s.
        }

        if($this->featured){ // getting the filtering by 'Featured Products' product status, we will add more condition to the productsQuery.
            $productsQuery->where('is_featured', 1); // getting only the products that have the is_featured status of 1.
        }

        if($this->on_sale){ // getting the filtering by 'On Sale' product status, we will add more condition to the productsQuery.
            $productsQuery->where('on_sale', 1); // getting only the products that have the on_sale status of 1.
        }

        if($this->max_price_range){ // getting the filtering by 'Price', we will add more condition to the productsQuery.
            $productsQuery->whereBetween('price', [0, $this->max_price_range]); // getting only the products that have price from 0 to (max_price_range as max price). 
        }

        if($this->sort_by == 'latest'){ 
            $productsQuery->latest(); // sorting by 'latest'.
        }

        if($this->sort_by == 'price'){
            $productsQuery->orderBy('price'); // sorting by 'price'.
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