<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\FavoriteProduct;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {

        $cart = Cart::where('user_id', $request->user()->id)->with('cart_items')->first();
        $bookmarked_products = FavoriteProduct::where('user_id', $request->user()->id)->pluck('product_id')->toArray();

        $orders = Order::where('user_id', $request->user()->id)->latest()->paginate(10);

        return view('orders.index', compact('bookmarked_products', 'cart', 'orders'));
    }

    public function show($id, Request $request)
    {
        $order = Order::where('id', $id)->with('orderItems')->first();

        if (!$order) {
            return redirect()->route('orders.index');
        }

        if ($order->user_id !== $request->user()->id) {
            return redirect()->route('orders.index');
        }

        $cart = Cart::where('user_id', $request->user()->id)->with('cart_items')->first();
        $bookmarked_products = FavoriteProduct::where('user_id', $request->user()->id)->pluck('product_id')->toArray();

        return view('orders.show', compact('bookmarked_products', 'order', 'cart'));
    }
}
