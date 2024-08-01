<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ShipDivision;
use Illuminate\Http\Request;
use App\Helpers\ShoppingCart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Exception;

class CartController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if(Session::has('coupon')){
            Session::forget('coupon');
        }

        try {

            if($product->discount_price == NULL){
                ShoppingCart::cartAdd([
                    'id' => $id,
                    'name' => $request->product_name,
                    'qty' => $request->qty,
                    'price' => $product->selling_price,
                    'weight' => 1,
                    'options' => [
                        'image' => $product->product_thumbnail,
                        'size' => $request->size,
                        'color' => $request->color,
                        ]
                ]);

                return response()->json(['success' => 'Successfully added on your cart'],200);
            }else{
                ShoppingCart::cartAdd([
                    'id' => $id,
                    'name' => $request->product_name,
                    'qty' => $request->qty,
                    'price' => $product->discount_price,
                    'weight' => 1,
                    'options' => [
                        'image' => $product->product_thumbnail,
                        'size' => $request->size,
                        'color' => $request->color,
                        ]
                ]);
                return response()->json(['success' => 'Successfully added on your cart'],200);
            }

        } catch(Exception $e) {
            Log::alert($e);
            return response()->json(['error' => $e], 500);
        }
    }

    public function getMiniCart()
    {
        try {

            $carts = ShoppingCart::cartContent();
            $cart_qty = ShoppingCart::cartCount();
            $cart_total = ShoppingCart::cartTotal();

            return response()->json([
                'carts' => $carts,
                'cart_qty' => $cart_qty,
                'cart_total' => round($cart_total),
            ], 200);

        } catch(Exception $e) {
            Log::alert($e);
            return response()->json(['error' => $e], 500);
        }
    }

    public function removeMiniCart($rowId)
    {
        try {
            ShoppingCart::cartRemove($rowId);
            return response()->json(['success' => 'Product Remove from Cart'],200);
        } catch(Exception $e) {
            Log::alert($e);
            return response()->json(['error' => $e], 500);
        }
    }

}
