<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function index()
    {
        return view('home');
    }

    public function movies()
    {
        return view('movies');
    }

    public function tvshows()
    {
        return view('tvshows');
    }

    public function newReleases()
    {
        return view('new-releases');
    }

    public function myList()
    {
        $user = Auth::user();
        return view('user.my-list', compact('user'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function settings()
    {
        $user = Auth::user();
        return view('user.settings', compact('user'));
    }
}
