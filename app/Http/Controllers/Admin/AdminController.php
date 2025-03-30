<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class AdminController extends BaseController
{
    //
    public function index()
    {
        return view('admin.dashboard');
    }
}
