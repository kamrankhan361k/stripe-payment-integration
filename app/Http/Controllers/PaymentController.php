<?php

namespace App\Http\Controllers;
use Stripe\Stripe;
use Stripe\Charge;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
     // Show payment form
     public function index()
     {
         return view('payment.index');
     }
 
     // Process the payment
     public function processPayment(Request $request)
     {
         // Set your secret key
         Stripe::setApiKey(env('STRIPE_SECRET'));
 
         try {
             // Create the charge
             $charge = Charge::create([
                 "amount" => 1000, // Amount in cents (e.g., 1000 = $10)
                 "currency" => "usd",
                 "source" => $request->stripeToken, // Stripe token from the form
                 "description" => "Test payment from Laravel",
             ]);
 
             return back()->with('success', 'Payment successful!');
         } catch (\Exception $e) {
             return back()->with('error', 'Error! ' . $e->getMessage());
         }
     }
}
