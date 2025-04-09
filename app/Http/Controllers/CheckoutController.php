<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function process()
    {
   
           
            
            return view('subscription.checkout');
            
        
    }


    public function success(Request $request)
    {
        return view('subscription.success');
    }

    public function cancel(Request $request)
    {
        return view('subscription.cancel');
    }
}
