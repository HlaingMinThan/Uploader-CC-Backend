<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __invoke()
    {
        request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'max:16']
        ]);

        if (!auth()->attempt(request()->only(['email', 'password']))) {
            throw new AuthenticationException();
        }
    }
}
