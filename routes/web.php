<?php

use App\Livewire\CartPage;
use App\Livewire\CategoriesPage;
use App\Livewire\CheckoutPage;
use App\Livewire\HomePage;
use App\Livewire\ProductDetailsPage;
use App\Livewire\ProductsPage;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', HomePage::class);

Route::get('/categories', CategoriesPage::class);

Route::get('/products', ProductsPage::class);

Route::get('/products/{product}', ProductDetailsPage::class);

Route::get('/cart', CartPage::class);

Route::get('/checkout', CheckoutPage::class);