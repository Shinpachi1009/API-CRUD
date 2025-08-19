<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request, User $user){}

    public function change(Request $request, User $user)
    {
        $input = $input = $request -> validate([
            'name'=>['required', 'max:50'],
            'email'=>['required', 'email', 'unique:users'],
            'password'=>['required', 'confirmed', 'min:8', 'max:20']
        ]);

        $user->update($input);
        return [$user, 'message'=>'Change saved'];
    }
}
