<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\FavoriteProduct;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        // Get the top 5 best rated products
        $featured_products = Product::where('reviews_count', '>=', 2)->where('average_rating', '>=', 3)->orderBy('average_rating', 'desc')->take(5)->get();

        // Truncate the description of the featured products
        foreach ($featured_products as $featured_product) {
            $max_len = 100;
            if (strlen($featured_product->description) > $max_len) {
                $last_pos = ($max_len - 3) - strlen($featured_product->description);
                $featured_product->description = substr($featured_product->description, 0, $last_pos) . '...';
            }
        }

        $recommended_products = Product::orderBy('sales_count', 'desc')->take(10)->get();

        if (!$request->user()) {
            $bookmarked_products = [];
            $cart = null;
        } else {
            $cart = Cart::where('user_id', $request->user()->id)->with('cart_items')->first();
            $bookmarked_products = FavoriteProduct::where('user_id', $request->user()->id)->pluck('product_id')->toArray();
        }
        return view('home', compact('featured_products', 'recommended_products', 'bookmarked_products', 'cart'));
    }

    public function profile(Request $request)
    {
        if (!$request->user()) {
            $bookmarked_products = [];
            $cart = null;
        } else {
            $bookmarked_products = FavoriteProduct::where('user_id', $request->user()->id)->with('product')->get();
            $cart = Cart::where('user_id', $request->user()->id)->with('cart_items')->first();
        }
        return view('profile', compact('cart', 'bookmarked_products'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'new_password' => ['nullable', 'confirmed']
        ]);

        // Check if the provided email already exists
        $email = $request->email;
        $existingUserWithEmail = User::where('email', $email)->first();
        $loggedInUser = auth()->user();

        if ($existingUserWithEmail && $existingUserWithEmail->id !== $loggedInUser->id) {
            return redirect()->back()->with('error', 'Another user with the same email already exists.');
        }

        // Update profile
        $user = User::find($loggedInUser->id);
        $user->name = $request->name;
        $user->email = $request->email;

        // Check if the old password is provided
        if ($request->filled('old_password')) {
            $oldPassword = $request->old_password;
            // Verify old password
            if (!password_verify($oldPassword, $user->password)) {
                return redirect()->back()->with('error', 'Incorrect current password.');
            }

            // Update password if new password is provided
            if ($request->filled('new_password')) {
                $newPassword = bcrypt($request->new_password);
                $user->password = $newPassword;
            }
        } else {
            // If the current user is logged in with github or google the password will be null
            if (!$user->password) {
                // Update password if new password is provided
                if ($request->filled('new_password')) {
                    $newPassword = bcrypt($request->new_password);
                    $user->password = $newPassword;
                }
            }
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }


    public function bookmarks(Request $request)
    {
        if (!$request->user()) {
            $bookmarked_products = [];
            $cart = null;
        } else {
            $bookmarked_products = FavoriteProduct::where('user_id', $request->user()->id)->with('product')->get();
            $cart = Cart::where('user_id', $request->user()->id)->with('cart_items')->first();
        }
        return view('bookmarks', compact('bookmarked_products', 'cart'));
    }

    public function cart(Request $request)
    {
        if (!$request->user()) {
            $cart = null;
            $cart_items = [];
        } else {
            $cart = Cart::where('user_id', $request->user()->id)->first();

            if ($cart) {
                $cart_items = CartItem::where('cart_id', $cart->id)->with('product')->get();
            } else {
                $cart_items = [];
            }
        }

        return view('cart.cart', compact('cart', 'cart_items'));
    }

    public function shop(Request $request)
    {
        if (!$request->user()) {
            $bookmarked_products = [];
            $cart = null;
        } else {
            $bookmarked_products = FavoriteProduct::where('user_id', $request->user()->id)->pluck('product_id')->toArray();;
            $cart = Cart::where('user_id', $request->user()->id)->with('cart_items')->first();
        }

        $categories = Category::all();

        return view('shop', compact('bookmarked_products', 'cart', 'categories'));
    }

    public function product($id, Request $request)
    {
        $product = Product::find($id);

        $category_ids = [];

        foreach ($product->categories as $category) {
            array_push($category_ids, $category->id);
        }

        $related_products = Product::latest()->whereHas('categories', function (Builder $query) use ($category_ids) {
            $query->whereIn('categories.id', $category_ids);
        })->take(7)->get();

        if (!$request->user()) {
            $bookmarked_products = [];
            $cart = null;
            $reviews = [];
        } else {
            $cart = Cart::where('user_id', $request->user()->id)->with('cart_items')->first();
            $bookmarked_products = FavoriteProduct::where('user_id', $request->user()->id)->pluck('product_id')->toArray();
            $reviews = Review::latest()->where('product_id', $id)->with('user')->get();
        }

        return view('products.show', compact('product', 'bookmarked_products', 'cart', 'reviews', 'related_products'));
    }

    public function checkout(Request $request)
    {
        $bookmarked_products = FavoriteProduct::where('user_id', $request->user()->id)->pluck('product_id')->toArray();;
        $cart = Cart::where('user_id', $request->user()->id)->with('cart_items')->first();

        if (!$cart || $cart->total_items === 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $cart_items = CartItem::where('cart_id', $cart->id)->with('product')->get();

        return view('checkout', compact('bookmarked_products', 'cart', 'cart_items'));
    }
}
