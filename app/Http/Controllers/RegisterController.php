<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Header;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required|max:225',
            'username' => 'required|min:7|max:225|unique:users,username',
            'email' => 'required|email|max:225|unique:users,email',
            'password' => 'required|min:7|max:225'
        ]);

        $user = User::create($attributes);

        // login
        auth()->login($user);

        return redirect('/')->with('success', 'Your Account has been created!');
        // the with() method will flash this message to the sessions.
    }
}
