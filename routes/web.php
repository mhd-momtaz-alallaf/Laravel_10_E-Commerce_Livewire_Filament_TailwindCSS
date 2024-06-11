<?php

use App\Livewire\Auth\ForgetPasswordPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\CancelPage;
use App\Livewire\CartPage;
use App\Livewire\CategoriesPage;
use App\Livewire\CheckoutPage;
use App\Livewire\HomePage;
use App\Livewire\MyOrderDetailsPage;
use App\Livewire\MyOrdersPage;
use App\Livewire\ProductDetailsPage;
use App\Livewire\ProductsPage;
use App\Livewire\SuccessPage;
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

Route::get('/login', LoginPage::class)
    ->name('login');

Route::get('/register', RegisterPage::class)
    ->name('register');

Route::get('/forget-password', ForgetPasswordPage::class)
    ->name('forget-password');

Route::get('/reset-password', ResetPasswordPage::class)
    ->name('reset-password');

Route::get('/', HomePage::class)
    ->name('home');

Route::get('/categories', CategoriesPage::class)
    ->name('categories');

Route::get('/products', ProductsPage::class)
    ->name('products');

Route::get('/products/{product:slug}', ProductDetailsPage::class) // Showing the Product Details by the product slug instead of product id.
    ->name('product-details');

Route::get('/cart', CartPage::class)
    ->name('cart');

Route::get('/checkout', CheckoutPage::class)
    ->name('checkout');

Route::get('/my-orders', MyOrdersPage::class)
    ->name('my-orders');

Route::get('/my-orders/{order}', MyOrderDetailsPage::class)
    ->name('my-order-details');

Route::get('/success', SuccessPage::class)
    ->name('success');

Route::get('/cancel', CancelPage::class)
    ->name('cancel');