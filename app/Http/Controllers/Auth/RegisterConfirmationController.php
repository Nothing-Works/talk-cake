<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class RegisterConfirmationController extends Controller
{
    public function index(Request $request)
    {
        User::whereConfirmationToken($request->input('token'))->firstOrFail()->confirm();

        return redirect('/threads')->with('flash', 'Your account is now confirmed! You may post to the forum');
    }
}
