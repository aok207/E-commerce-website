<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $categories = Category::where('name', 'like', '%' . $request->search . '%')->paginate(6);
        } else {

            $categories = Category::orderBy('id', 'asc')->paginate(6);
        }

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formData = $request->validate([
            'name' => ['required', 'string']
        ]);

        if (Category::where('name', $formData['name'])->get()->first()) {
            return redirect()->back()->with('error', 'Category already exists.');
        }

        Category::create([
            'slug' => Str::slug($formData['name']),
            'name' => $formData['name']
        ]);

        return redirect()->back()->with('success', 'Category created successfully.');
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
    public function edit(string $slug)
    {
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            abort(404);
        }

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $formData = $request->validate([
            'name' => ['required', 'string']
        ]);

        $newSlug = Str::slug($formData['name']);

        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            abort(404);
        }

        $category->update([
            'slug' => $newSlug,
            'name' => $formData['name']
        ]);

        return redirect(route('admin.categories.edit', $newSlug))->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            abort(404);
        }

        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
