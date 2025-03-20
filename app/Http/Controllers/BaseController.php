<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * Common data for all views.
     *
     * @var array
     */
    protected $viewData = [];

    /**
     * Constructor to initialize common view data.
     */
    public function __construct()
    {
        $this->viewData = [
            'appName' => config('app.name'),
            // Add other common data as needed
        ];
    }

    /**
     * Render view with common data.
     *
     * @param  string  $view
     * @param  array  $data
     * @return \Illuminate\View\View
     */
    protected function view($view, $data = [])
    {
        return view($view, array_merge($this->viewData, $data));
    }

    /**
     * Redirect with success message.
     *
     * @param  string  $route
     * @param  array  $parameters
     * @param  string  $message
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function successRedirect($route, $parameters = [], $message = 'Operation successful')
    {
        return redirect()->route($route, $parameters)->with('success', $message);
    }

    /**
     * Redirect with error message.
     *
     * @param  string  $route
     * @param  array  $parameters
     * @param  string  $message
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function errorRedirect($route, $parameters = [], $message = 'An error occurred')
    {
        return redirect()->route($route, $parameters)->with('error', $message);
    }

    /**
     * Redirect back with input and error messages.
     *
     * @param  array  $errors
     * @param  string  $message
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function backWithErrors($errors, $message = 'Please check the form for errors')
    {
        return back()->withInput()->withErrors($errors)->with('error', $message);
    }
}
