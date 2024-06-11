<?php

namespace App\Livewire\Home;

use App\Models\Category;
use Livewire\Component;

class Categories extends Component
{
    public function render()
    {
        $categories = Category::where('is_active', 1)->get(); // Getting all active categories form the database.

        return view('livewire.home.categories', [
            'categories'=> $categories, // Passing the $categories collection to the view.
        ]);
    }
}
