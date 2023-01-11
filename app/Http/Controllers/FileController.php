<?php

namespace App\Http\Controllers;

use App\Http\Resources\FileResource;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index()
    {
        return FileResource::collection(auth()->user()->files);
    }
}
