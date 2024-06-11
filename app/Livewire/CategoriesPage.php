<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Categories | E-Commerce')] // Livewire Attribute for Changing the Default page title.

class CategoriesPage extends Component
{
    public function render()
    {
        $categories = Category::where('is_active', 1)->get(); // Getting all active categories form the database.

        return view('livewire.categories-page', [
            'categories'=> $categories, // Passing the $categories collection to the view.
        ]);
    }
}
