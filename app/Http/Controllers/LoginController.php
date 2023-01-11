<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __invoke()
    {
        if (!auth()->attempt(request()->only(['email', 'password']))) {
            throw new AuthenticationException();
        }
    }
}
