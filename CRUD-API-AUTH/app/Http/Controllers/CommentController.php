<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CommentController extends Controller implements HasMiddleware
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
    public function index(Post $post)
    {
        return $post->comments;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        $input = $request -> validate([
            'body'=>['required', 'max:100']
        ]);

        $comment = $request->user()->comments()->create([
            'body'=>$input['body'], 'post_id'=>$post->id
        ]);
        return [$comment, 'message'=>'Comment have been Posted'];
    }


    /**
     * Display the specified resource.
     */
    public function show(Post $post, Comment $comment)
    {
        return $comment;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post, Comment $comment)
    {
        //$input = $request->validate
        //([
        //    'body'=>['required', 'max:100'],
        //]);
        //
        //$comment->update($input);
        //return [$comment, 'message'=>'comment updated'];

        if($request->user()->id !== $comment->user_id){
            return ['message'=>'You did not own this comment'];
        }
        $input=$request->validate([
            'body'=>['required', 'max:100'],
        ]);
        $comment->update($input);
        return [$comment, 'message'=>'comment updated'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post, Comment $comment)
    {
        if($request->user()->id !== $comment->user_id){
            return['message'=>'You did not own this comment'];
        }

        $comment->delete();
        return ['message'=>'comment deleted'];
    }
}
