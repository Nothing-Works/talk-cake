<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;

class RegisterConfirmationController extends Controller
{
    public function index(Request $request)
    {
        try {
            User::whereConfirmationToken($request->input('token'))->firstOrFail()->confirm();
        } catch (Exception $e) {
            return redirect(route('threads'))->with('flash', 'Unknown token');
        }

        return redirect(route('threads'))->with('flash', 'Your account is now confirmed! You may post to the forum');
    }
}
