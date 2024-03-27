<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewAPIController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'rating' => ['required', 'numeric', 'min:1', 'max:5'],
            'feedback' => ['required'],
            'product_id' => ['required', 'exists:products,id']
        ]);

        $product_id = $request->product_id;

        $new_review = Review::create([
            'user_id' => $request->user()->id,
            'product_id' => $product_id,
            'rating' => $request->rating,
            'feedback' => $request->feedback
        ]);

        $created_review = Review::where('id', $new_review->id)->with('user')->first();

        $new_avg_rating = Review::where('product_id', $product_id)->avg('rating');

        $product = Product::where('id', $product_id)->first();

        $product->update([
            'average_rating' => round($new_avg_rating, 2),
            'reviews_count' => $product->reviews_count + 1
        ]);

        return response()->json(['review' => $created_review, 'product' => $product, 'message' => 'Review created successfully.'], 200);
    }
}
