@php
use Stripe\Stripe;
use Stripe\Checkout\Session;

// Make sure STRIPE_SECRET_KEY is set in your .env file
Stripe::setApiKey(config('services.stripe.secret'));
header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost:8000/subscribe/checkout';

$checkout_session = Session::create([
  'line_items' => [[
    'price' => 'price_1RBu4lPaslh9ofaKNH0FgKan',
    'quantity' => 1,
  ]],
  'mode' => 'subscription',
  'success_url' => $YOUR_DOMAIN . '/success',
  'cancel_url' => $YOUR_DOMAIN . '/cancel',
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
@endphp