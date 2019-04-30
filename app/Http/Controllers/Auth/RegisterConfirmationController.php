<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class RegisterConfirmationController extends Controller
{
    public function index(Request $request)
    {
        $user = User::whereConfirmationToken($request->input('token'))->first();

        if (!$user) {
            return redirect(route('threads'))->with('flash', 'Unknown token');
        }

        $user->confirm();

        return redirect(route('threads'))->with('flash', 'Your account is now confirmed! You may post to the forum');
    }
}
