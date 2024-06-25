<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Checkout | E-Commerce')] // Livewire Attribute for Changing the Default page title.

class CheckoutPage extends Component
{
    public $first_name; // livewire properties to handel the passed form view values.
    public $last_name;
    public $phone;
    public $street_address;
    public $city;
    public $state;
    public $zip_code;
    public $payment_method;

    public function placeOrder() // Storing the User Order into the database.
    {
        $this->validate([ // validating the form data. 
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'street_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'payment_method' => 'required',
        ]);

        $cart_items = CartManagement::getCartItemsFromCookie(); // getting the cart items of the user from the cookie.

        $line_items = [];

        foreach($cart_items as $item) // getting the price information of each item in the cart.
        {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'USD',
                    'unit_amount' => $item['unit_amount'] * 100,
                    'product_data' => [
                        'name' => $item['name'],
                    ]
                ],
                'quantity' => $item['quantity'],
            ];

            $order = new Order(); // creating a new order.

            $order->user_id = auth()->user()->id;
            $order->grand_total = CartManagement::calculateCartItemsGrandTotal($cart_items);

        }
    }

    public function render()
    {
        $cart_items = CartManagement::getCartItemsFromCookie(); // getting the cart items from the cookie.
        $grand_total = CartManagement::calculateCartItemsGrandTotal($cart_items); // getting the grand total of the cart items.

        return view('livewire.checkout-page', [
            'cart_items' => $cart_items, // passing the attributes to the view.
            'grand_total' => $grand_total,
        ]);
    }
}
