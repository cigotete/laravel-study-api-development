<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::included()
                        ->filter()
                        ->sort()
                        ->getOrPaginate();
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required|max:255',
                'slug' => 'required|max:255|unique:categories', //unique in table 'categories'
            ]);

            $category = Category::create($request->all());
            return CategoryResource::make($category);

        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            // Get relation with post's tags and user's post.
            $category = Category::included()->findOrFail($id);
            return CategoryResource::make($category);
            // Get relation with post.
            //return Category::with('posts')->findOrFail($id);
            //return $category; // Uses of Model Binding implies model as parameter.
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $category = Category::findOrFail($id);
            $request->validate([
                'name' => 'required|max:255',
                'slug' => 'required|max:255|unique:categories,slug,' . $category->id,
            ]);
            $category->update($request->all());

            return CategoryResource::make($category);

        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $category = Category::findOrFail($id);
            $category->delete($id);

            return CategoryResource::make($category);

        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }
}
