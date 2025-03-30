<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class AuthViewController extends BaseController
{
    /**
     * Show the login page.
     *
     * @return \Illuminate\View\View
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Show the registration page.
     *
     * @return \Illuminate\View\View
     */
    public function showRegister()
    {
        return view('auth.register');
    }
}
