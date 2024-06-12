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
    public static function ClearCartItemsFromCookie(){
        Cookie::queue(Cookie::forget('cart_items')); // Forget the Cookie named 'cart_items'.
    }

    // get all cart items from the Cookie
    public static function GetCartItemsFromCookie(){
        $cart_items = json_decode(Cookie::get('cart_items', true)); // converting the cart_items from json format to a collection.

        if(!$cart_items){
            $cart_items = [];
        }

        return $cart_items;
    }

    // increment items Quantity

    // decrement items Quantity

    // calculate grand total
}