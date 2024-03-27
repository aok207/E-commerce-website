<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\FavoriteProduct;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class ProductAPIController extends Controller
{
    public function bookmark_product(Request $request)
    {
        $user = $request->user();
        $product = Product::find($request->id);

        $checkIfAlreadyBookmarked = FavoriteProduct::where('user_id', $user->id)->where('product_id', $product->id)->first();

        if ($checkIfAlreadyBookmarked) {
            return response()->json([
                'message' => 'Product already bookmarked.'
            ], 500);
        }

        if ($product) {
            FavoriteProduct::create([
                'user_id' => $user->id,
                'product_id' => $product->id
            ]);
            return response()->json(['message' => 'Product bookmarked successfully'], 200);
        } else {
            return response()->json([
                'error' => 'Product not found'
            ], 404);
        }
    }
    public function unbookmark_product(Request $request)
    {
        $user = $request->user();
        $product = Product::find($request->id);

        $checkIfAlreadyBookmarked = FavoriteProduct::where('user_id', $user->id)->where('product_id', $product->id)->first();

        if (!$checkIfAlreadyBookmarked) {
            return response()->json([
                'message' => 'Product not bookmarked'
            ], 404);
        }

        $checkIfAlreadyBookmarked->delete();

        return response()->json(['message' => 'Product unbookmarked successfully'], 200);
    }

    public function get_products(Request $request)
    {
        $query = Product::latest();

        if ($request->query('categories')) {
            $categories = json_decode($request->query('categories'));

            $query->whereHas('categories', function (Builder $query) use ($categories) {
                $query->whereIn('categories.id', $categories);
            });
        }

        if ($request->query('min_price') && $request->query('max_price')) {
            $min_price = $request->query('min_price');
            $max_price = $request->query('max_price');

            $query->whereBetween('price', [$min_price, $max_price]);
        } else {
            if ($request->query('min_price')) {
                $min_price = $request->query('min_price');
                $query->where('price', '>', $min_price);
            }

            if ($request->query('max_price')) {
                $max_price = $request->query('max_price');
                $query->where('price', '<', $max_price);
            }
        }

        $products = $query->paginate(10);

        return response()->json(["products" => $products], 200);
    }
}
