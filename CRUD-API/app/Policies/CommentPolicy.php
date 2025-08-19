<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function modifyComment(User $user, Comment $comment): Response
    {
        return $user->id === $comment->user_id
        ? Response::allow()
        : Response::deny('You did not own this post');
    }
}
