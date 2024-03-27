<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;

class OrderAPIController extends Controller
{
    public function createOrder(Request $request)
    {
        // return Cart::where('user_id', $request->user()->id)->first()->cart_items;
        $request->validate([
            "email" => ['email', 'required'],
            "address" => ['required'],
            "city" => ['required'],
            "zip" => ['required'],
            "total_price" => ['required'],
            "tax_price" => ['required']
        ]);

        $user_id = $request->user()->id;
        $cart = Cart::where('user_id', $user_id)->first();

        $order = Order::create([
            "user_id" => $user_id,
            "total_price" => $request->total_price,
            "total_items" => $cart->total_items,
            "order_status" => 'pending'
        ]);

        $created_order = Order::find($order->id);

        // Create order items
        foreach ($cart->cart_items as $item) {
            OrderItem::create([
                "order_id" => $created_order->id,
                "product_id" => $item->product_id,
                "quantity" => $item->quantity
            ]);

            // Update the quantity in stock of the original product
            $product = $item->product;

            $product->update([
                'quantity_in_stock' => $product->quantity_in_stock - $item->quantity
            ]);

            // Remove the current cart items
            $item->delete();
        }

        // Create the payment
        Payment::create([
            'order_id' => $created_order->id,
            'payment_type' => 'paypal',
            'payment_status' => 'unpaid',
            'email' => $request->email,
            'shipping_address' => $request->address,
            'city' => $request->city,
            'zip_code' => $request->zip,
            'email' => $request->email,
            'tax_fees' => $request->tax_price,
            'shipping_fees' => 0,
            'total_items_price' => $cart->total_price,
            'final_amount' => $request->total_price,
        ]);

        // reset the cart
        $cart->update([
            'total_price' => 0,
            'total_items' => 0
        ]);

        return response(['success' => true, 'redirect_url' => url('/orders', [$created_order->id])], 200);
    }
}
