<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request)
    {
        return UserResource::make($request->user());
    }

    public function usage(Request $request)
    {
        return [
            'data' => $request->user()->usage()
        ];
    }
}
