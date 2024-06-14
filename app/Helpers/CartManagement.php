<?php

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartManagement{ // This helper will Provide:
    // add item to the cart
    public static function addItemToCart($product_id){ // this function will add the Product($product_id) to the cart.
        $cart_items = self::getCartItemsFromCookie(); // getting the cart items from the cookie.
        
        $existing_item = null;

        foreach ($cart_items as $key => $item){
            // checking if the current product is already available in the $cart_items cookie array or not.
            if($item['product_id']  == $product_id){
                $existing_item = $key; // if the product is already in the cart, change the $existing_item value to ($key) to use it later.
                break;
            }
        }

        if($existing_item !== null){ // if the $existing_item is not null(the product is already in the cart),
            $cart_items[$existing_item]['quantity']++; // so just increase the quantity of that item(product) by 1.

            $cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] * $cart_items[$existing_item]['unit_amount']; // and change the 'total_amount' of that product to ('quantity' * 'unit_amount') of that product.
        }
        else{ // else $existing_item == null (the product is not in the cart)
            $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'images']); // getting some attributes of the product.

            if($product){ // if the product exists.
                $cart_items[] = [ // assigning the product to the $cart_items.
                    'product_id' => $product_id,
                    'name' => $product->name,
                    'image' => $product->images[0],
                    'quantity' => 1,
                    'unit_amount' => $product->price,
                    'total_amount' => $product->price,
                ];
            }
        }

        self::addCartItemsToCookie($cart_items); // adding the $cart_items to the cookie.

        return count($cart_items); // returning the $cart_items count.
    }

    // add item to the cart with quantity
    public static function addItemToCartWithQuantity($product_id, $quantity = 1){ // this function will add the Product($product_id) with the passed quantity to the cart.
        $cart_items = self::getCartItemsFromCookie(); // getting the cart items from the cookie.
        
        $existing_item = null;

        foreach ($cart_items as $key => $item){
            // checking if the current product is already available in the $cart_items cookie array or not.
            if($item['product_id']  == $product_id){
                $existing_item = $key; // if the product is already in the cart, change the $existing_item value to ($key) to use it later.
                break;
            }
        }

        if($existing_item !== null){ // if the $existing_item is not null(the product is already in the cart),
            $cart_items[$existing_item]['quantity'] = $quantity; // so just increase the quantity of that item(product).

            $cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] * $cart_items[$existing_item]['unit_amount']; // and change the 'total_amount' of that product to ('quantity' * 'unit_amount') of that product.
        }
        else{ // else $existing_item == null (the product is not in the cart)
            $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'images']); // getting some attributes of the product.

            if($product){ // if the product exists.
                $cart_items[] = [ // assigning the product to the $cart_items.
                    'product_id' => $product_id,
                    'name' => $product->name,
                    'image' => $product->images[0],
                    'quantity' => $quantity,
                    'unit_amount' => $product->price,
                    'total_amount' => $product->price,
                ];
            }
        }

        self::addCartItemsToCookie($cart_items); // adding the $cart_items to the cookie.

        return count($cart_items); // returning the $cart_items count.
    }
    
    // remove item from the cart
    public static function removeCartItem($product_id){ // this function will remove the Product($product_id) from the cart.
        $cart_items = self::getCartItemsFromCookie(); // getting the cart items from the cookie.

        foreach ($cart_items as $key => $item){
            if($item['product_id'] == $product_id){ // finding the product inside the $cart_items cookie.
                unset($cart_items[$key]); // removing the product from the cart.
            }
        }

        self::addCartItemsToCookie($cart_items); // Re adding the new $cart_items to the cookie after the update.

        return $cart_items;
    }

    // add cart items to the Cookie
    public static function addCartItemsToCookie($cart_items){
        Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 * 30); // converting the cart_items to json format, cookie name is cart_items, the expiration time will be 30 days.
    }

    // clean cart items from the Cookie
    public static function clearCartItemsFromCookie(){
        Cookie::queue(Cookie::forget('cart_items')); // Forget the Cookie named 'cart_items'.
    }

    // get all cart items from the Cookie
    public static function getCartItemsFromCookie(){
        $cart_items = json_decode(Cookie::get('cart_items'), true); // converting the cart_items from json format to a collection.

        if(!$cart_items){
            $cart_items = [];
        }

        return $cart_items;
    }

    // increment items Quantity
    public static function incrementQuantityOfCartItem($product_id){
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item){
            if($item['product_id'] == $product_id){ // finding the product inside the $cart_items cookie.
                $cart_items[$key]['quantity']++ ; //increasing the quantity of that item(product) by 1.
                $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount']; // and change the 'total_amount' of that product to ('quantity' * 'unit_amount') of that product.
            }
        }

        self::addCartItemsToCookie($cart_items); // Re adding the new $cart_items to the cookie after the update.

        return $cart_items;
    }

    // decrement items Quantity
    public static function decrementQuantityOfCartItem($product_id){
        $cart_items = self::getCartItemsFromCookie(); // getting the cart items from the cookie.

        foreach ($cart_items as $key => $item){
            if($item['product_id'] == $product_id){ // finding the product inside the $cart_items cookie.
                if($item['quantity'] > 1){ // ensuring not getting negative quantity.
                    $cart_items[$key]['quantity']-- ; //decreasing the quantity of that item(product) by 1.
                    $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount']; // and change the 'total_amount' of that product to ('quantity' * 'unit_amount') of that product.
                }
            }
        }

        self::addCartItemsToCookie($cart_items); // Re adding the new $cart_items to the cookie after the update.

        return $cart_items;
    }

    // calculate cart items grand total
    public static function calculateCartItemsGrandTotal($cart_items){
        return array_sum(array_column($cart_items, 'total_amount')); // calculating the sum of the 'total_amount' field of each item in the $cart_items array.
    }
}