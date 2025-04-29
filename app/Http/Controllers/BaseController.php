<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{

    protected $viewData = [];


    public function __construct()
    {
        $this->viewData = [
            'appName' => config('app.name'),
        ];
    }


    protected function view($view, $data = [])
    {
        return view($view, array_merge($this->viewData, $data));
    }


    protected function successRedirect($route, $parameters = [], $message = 'Operation successful')
    {
        return redirect()->route($route, $parameters)->with('success', $message);
    }


    protected function errorRedirect($route, $parameters = [], $message = 'An error occurred')
    {
        return redirect()->route($route, $parameters)->with('error', $message);
    }


    protected function backWithErrors($errors, $message = 'Please check the form for errors')
    {
        return back()->withInput()->withErrors($errors)->with('error', $message);
    }
}
