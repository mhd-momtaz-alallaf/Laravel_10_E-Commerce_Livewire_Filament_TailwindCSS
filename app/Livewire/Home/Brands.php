<?php

namespace App\Livewire\Home;

use App\Models\Brand;
use Livewire\Component;

class Brands extends Component
{
    public function render()
    {
        $brands = Brand::where('is_active', 1)->get(); // Getting all active brands form the database.

        return view('livewire.home.brands',[
            'brands' => $brands // Passing the $brands collection to the view.
        ]);
    }
}
