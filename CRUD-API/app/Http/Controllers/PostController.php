<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware() 
    {
        return [
            new Middleware('auth:sanctum', except:['index', 'show'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'title'=>['required', 'max:25'],
            'caption'=>['required'],
            'image' => ['nullable', 'array', 'max:3'], // Must be an array, max 3 files
            'image.*' => ['file', 'max:2048', 'mimes:png,jpg,webp'], // Each file must be an image
        ]);

        //use to store the image if it exists
        $path = null;
        if($request->hasFile('image')) {
            $path = Storage::disk('public')->put('posts_images', $request->file('image'));
        }

        $post = $request->user()->posts()->create([
            'title'=>$request->title,
            'caption'=>$request->caption,
            'image'=>$path]);
        return [$post, 'message'=>'Post have been Posted'];
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('modifyPost', $post);
        $input = $request -> validate([
            'title'=>['required', 'max:25'],
            'caption'=>['required'],
        ]);

        $post->update($input);
        return [$post, 'message'=>'Post have been Updated'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('modifyPost', $post);

        if($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();
        return ['message'=>'post deleted'];
    }

    
}
