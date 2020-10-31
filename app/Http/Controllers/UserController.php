<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ViewedProfile;

class UserController extends Controller
{
    public function getLoggedIn()
    {
        return auth()->user();
    }

    public function get($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() !== $user->id) {
            $user->notify(new ViewedProfile(auth()->user()));
        }

        return $user;
    }

    public function getAll()
    {
        return User::all();
    }

    public function update()
    {
        $validateData = request()->validate(['name' => 'required|max:55']);

        auth()->user()->update($validateData);

        return auth()->user();
    }

    public function delete()
    {
        auth()->user()->delete();

        return response()->json(true);
    }
}
