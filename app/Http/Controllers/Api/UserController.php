<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('name');

        return   User::where('name', 'LIKE', "$search%")
            ->take(5)
            ->get(['name']);
    }
}
