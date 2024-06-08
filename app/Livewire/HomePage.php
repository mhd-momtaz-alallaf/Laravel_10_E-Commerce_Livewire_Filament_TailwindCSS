<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Home Page | E-Commerce')] // Livewire Attribute for Changing the Default page title.
    
class HomePage extends Component
{
    public function render()
    {
        return view('livewire.home-page');
    }
}
