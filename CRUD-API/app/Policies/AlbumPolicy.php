<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Album;
use App\Models\User;

class AlbumPolicy
{
    public function modifyAlbum(User $user, Album $album): Response
    {
        return $user->id === $album->user_id
        ? Response::allow()
        : Response::deny('You did not own this post');
    }
}
