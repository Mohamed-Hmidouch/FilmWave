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
        $user = Auth::user();
        
        if ($user) {
            $user->lifetime_access = true;
            $user->save();
            return redirect()->route('user.homme')->with('success', 'Succès! Votre plan a été mis à niveau. Profitez de votre accès premium!');
        } else {
            Log::error('No authenticated user found in checkout success method');
            return redirect()->route('login')->with('error', 'Please login to complete your subscription');
        }
    }

    public function cancel(Request $request)
    {
        return redirect()->route('home')->with('info', 'Votre processus d\'abonnement a été annulé.');
    }
}
