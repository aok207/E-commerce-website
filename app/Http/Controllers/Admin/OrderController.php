<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('id', 'desc')->with('payment')->paginate(6);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(string $id)
    {
        $order = Order::where('id', $id)->with('user')->with('payment')->first();
        $order_items = OrderItem::where('order_id', $order->id)->with('product')->get();

        // return $order_items;
        return view('admin.orders.show', compact('order', 'order_items'));
    }

    public function markAsDelivered(string $id)
    {
        $order = Order::where('id', $id)->first();
        $order->update([
            'order_status' => 'delivered'
        ]);

        return redirect()->back()->with('success', 'Marked as delivered.');
    }
}
