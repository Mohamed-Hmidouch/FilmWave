<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
