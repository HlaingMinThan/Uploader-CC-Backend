<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthenticationException;

class LoginController extends Controller
{
    public function __invoke()
    {
        request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'max:16']
        ]);

        if (!auth()->attempt(request()->only(['email', 'password']))) {
            throw new AuthenticationException();
        }
    }
}
