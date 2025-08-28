<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return User::all();;
    }

    public function show(User $user)
    {
        return $user;
    }

    public function register(Request $request)
    {
        $input = $request->validate([
                'name' => ['required', 'max:50'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'confirmed', 'min:8', 'max:20']
            ]);

        $user = User::create($input);
        $token = $user->createToken($request->name);
        return
            [
                'user' => $user,
                'token' => $token->plainTextToken,
                'message' => 'You are now Registered',
            ];
    }

    public function login(Request $request)
    {
        $request->validate([
                'email' => ['required', 'email', 'exists:users'],
                'password' => ['required']
            ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return ['message' => 'Password Incorrect'];
        }
        $token = $user->createToken($user->name);
        return [
            'user' => $user,
            'token' => $token->plainTextToken,
            'message' => 'You are now Logged In',
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return ['message' => 'You are Logged out'];
    }
}
