<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::included()
                        ->filter()
                        ->sort()
                        ->getOrPaginate();
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required|max:255',
                'slug' => 'required|max:255|unique:posts',
                'extract' => 'required',
                'body' => 'required',
                'category_id' => 'required|exists:categories,id',
                'user_id' => 'required|exists:users,id',
            ]);

            $post = Post::create($request->all());
            $tagsId = $request->input('tags_id');
            $tagsId = json_decode($tagsId, true);
            $post->tags()->sync($tagsId);
            return PostResource::make($post);

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
            $post = Post::included()->findOrFail($id);
            return PostResource::make($post);

        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        $post = Post::findOrFail($id);
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:posts,slug,' . $post->id,
            'extract' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
        ]);
        $post->update($request->all());
        $tagsId = $request->input('tags_id');
        $tagsId = json_decode($tagsId, true);
        $post->tags()->sync($tagsId);

        return PostResource::make($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $post = Post::findOrFail($id);
        $post->delete($id);

        return PostResource::make($post);
    }
}
