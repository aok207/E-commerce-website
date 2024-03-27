<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $products = Product::where('title', 'like', '%' . $request->search . '%')->orderBy('id', 'desc')->paginate(6);
        } else {
            $products = Product::orderBy('id', 'desc')->paginate(6);
        }

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form
        $request->validate([
            'title' => ['required', 'max:100'],
            'description' => ['required'],
            'price' => ['required'],
            'categories' => ['required'],
            'quantity' => ['required'],
        ]);

        // image upload
        $file = $request->file('image');
        $file_name = uniqid() . $file->getClientOriginalName();
        $file->move(public_path('/images'), $file_name);

        // Create product
        $addedProduct = Product::create([
            'title' => $request->title,
            'image' => $file_name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity_in_stock' => $request->quantity,
            'average_rating' => 0,
            'reviews_count' => 0
        ]);

        // sync product category
        $product = Product::find($addedProduct->id);
        $product->categories()->sync($request->categories);

        return redirect()->back()->with('success', 'Created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::where('id', $id)->with('categories')->first();
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the form
        $request->validate([
            'title' => ['required', 'max:100'],
            'description' => ['required'],
            'price' => ['required'],
            'categories' => ['required'],
            'quantity' => ['required'],
        ]);

        $product = Product::where('id', $id)->first();

        if (!$product) {
            abort(404);
        }

        if (!$request->file('image')) {
            $file_name = $product->image;
        } else {
            // Delete old image
            if (file_exists(public_path('/images/' . $product->image))) {
                unlink(public_path('/images/' . $product->image));
            }

            // image upload
            $file = $request->file('image');
            $file_name = uniqid() . $file->getClientOriginalName();
            $file->move(public_path('/images'), $file_name);
        }

        // Update the fields
        $product->update([
            'title' => $request->title,
            'image' => $file_name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity_in_stock' => $request->quantity,
        ]);

        return redirect()->back()->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::where('id', $id)->first();

        if (!$product) {
            abort(404);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
}
