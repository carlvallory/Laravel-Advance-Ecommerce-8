<?php

namespace App\Helpers;

use Gloudemans\Shoppingcart\Cart;

class ShoppingCart extends Cart {

    public static function cartAdd($id, $name = null, $qty = null, $price = null, $weight = 0, array $options = []) {
        return Cart::add($id, $name, $qty, $price, $weight, $options);
    }

    public static function cartUpdate($rowId, $qty){
        return Cart::update($rowId, $qty);
    }

    public static function cartRemove($rowId) {
        return Cart::remove($rowId);
    }

    public static function cartGet($rowId) {
        return Cart::get($rowId);
    }

    public static function cartDestroy() {
        return Cart::destroy();
    }

    public static function cartContent() {
        return Cart::content();
    }

    public static function cartCount() {

        return Cart::count();
    }

    public static function cartTotal($decimals = null, $decimalPoint = null, $thousandSeperator = null) {
        return Cart::total($decimals, $decimalPoint, $thousandSeperator);
    }

}
