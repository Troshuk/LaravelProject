<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register()
    {
        $validateData = request()->validate([
            'name' => 'required|max:55',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        return User::create($validateData);
    }

    public function login()
    {
        $loginData = request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        abort_if(!auth()->attempt($loginData), 400, 'Invalid credentials');

        return auth()->user()->createToken('authToken')->accessToken;
    }

    public function logout()
    {
        auth()->user()
            ->token()
            ->delete();

        return response()->json(true);
    }
}
