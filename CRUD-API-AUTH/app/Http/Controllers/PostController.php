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
        $input = $request -> validate([
            'title'=>['required', 'max:25'],
            'caption'=>['required'],
        ]);

        $post = $request->user()->posts()->create($input);
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
        $input = $request -> validate([
            'title'=>['required', 'max:25'],
            'caption'=>['required'],
        ]);

        $post->update($input);
        return [$post, 'message'=>'Post have been Posted'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return ['message'=>'post deleted'];
    }

    
}
