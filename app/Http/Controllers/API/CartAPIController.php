<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartAPIController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::where('id', $request->product_id)->first();

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $checkIfCartExist = Cart::where('user_id', $request->user()->id)->first();

        if (!$checkIfCartExist) {
            $new_cart = Cart::create([
                'user_id' => $request->user()->id,
                'total_price' => $product->price,
                'total_items' => 1
            ]);

            CartItem::create([
                'cart_id' => $new_cart->id,
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        } else {
            CartItem::create([
                'cart_id' => $checkIfCartExist->id,
                'product_id' => $product->id,
                'quantity' => 1
            ]);
            $checkIfCartExist->update([
                'total_price' => $checkIfCartExist->total_price + $product->price,
                'total_items' => $checkIfCartExist->total_items + 1
            ]);
        }

        return response()->json(['message' => 'Added to cart successfully.'], 200);
    }

    public function removeFromCart(Request $request)
    {
        $item_id = $request->item_id;

        $item = CartItem::where('id', $item_id)->first();
        $originalCart = Cart::where('id', $item->cart_id)->first();

        if (!$item) {
            return response()->json(['message' => 'Item does not exist in the cart.', 404]);
        }

        $originalCart->update([
            "total_items" => $originalCart->total_items - $item->quantity,
            "total_price" => $originalCart->total_price - ($item->quantity * $item->product->price)
        ]);

        $new_cart = Cart::where('id', $originalCart->id)->first();

        $item->delete();

        return response()->json(['message' => 'Item removed successfully.', 'new_cart' => $new_cart], 200);
    }

    public function changeItemCount(Request $request)
    {
        $item_id = $request->item_id;
        $new_quantity = $request->new_quantity;

        $item = CartItem::where('id', $item_id)->first();
        $originalCart = Cart::where('id', $item->cart_id)->first();

        if (!$item) {
            return response()->json(['message' => 'Item does not exist in the cart.', 404]);
        }

        // Don't allow when the selected quantity is greater than the quantity in stock
        if ($new_quantity > $item->product->quantity_in_stock) {
            return response()->json(['message' => 'Selected quantity is greater than the quantity in stock.'], 500);
        }

        // Update the total items and total price in the cart
        // Subtract the orginal values and add the new values
        $originalCart->update([
            "total_items" => ($originalCart->total_items - $item->quantity) + $new_quantity,
            "total_price" => ($originalCart->total_price - ($item->quantity * $item->product->price)) + ($new_quantity * $item->product->price)
        ]);

        // Update the quantity
        $item->update([
            "quantity" => $new_quantity
        ]);

        $new_cart = Cart::where('id', $originalCart->id)->first();

        return response()->json(['message' => 'Updated the cart successfully', 'new_cart' => $new_cart], 200);
    }
}
