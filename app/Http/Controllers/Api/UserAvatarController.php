<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UserAvatarController extends Controller
{

    /**
     * UserAvatarController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store()
    {

    }
}
