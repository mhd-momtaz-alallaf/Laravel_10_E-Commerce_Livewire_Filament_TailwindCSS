<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cookie;

class CartManagement{ // This helper will Provide:
    // add item to the cart

    // remove item from the cart

    // add cart items to the Cookie
    public static function addCartItemsToCookie($cart_items){
        Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 * 30); // converting the cart_items to json format, cookie name is cart_items, the expiration time will be 30 days.
    }

    // clean cart items from the Cookie
    public static function CleanCartItemsFromCookie(){
        Cookie::queue(Cookie::forget('cart_items')); // Forget the Cookie named 'cart_items'.
    }

    // get all cart items from the Cookie

    // increment items Quantity

    // decrement items Quantity

    // calculate grand total
}