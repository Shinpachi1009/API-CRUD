<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Image;
use App\Models\User;

class ImagePolicy
{
    public function modifyImage(User $user, Image $image): Response
    {
        return $user->id === $image->user_id
        ? Response::allow()
        : Response::deny('You did not own this image');
    }
}
