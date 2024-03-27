<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class PageController extends Controller
{
    public function dashboard()
    {
        $data = [
            "user_count" => User::count(),
            'product_count' => Product::count(),
            'order_count' => Order::count(),
            'latest_orders' => Order::orderBy('id', 'desc')->take(5)->with('user')->with('payment')->get()
        ];

        return view('admin.dashboard', compact('data'));
    }
}
