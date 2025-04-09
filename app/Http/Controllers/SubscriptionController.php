<?php

namespace App\Http\Controllers;

use Faker\Provider\Base;
use Illuminate\Http\Request;

class SubscriptionController extends BaseController
{
    //

    /**
     * Show the subscription page.
     *
     * @return \Illuminate\View\View
     */
    public function showSubscriptionPage()
    {
        return $this->view('subscription.plans');
    }
}
