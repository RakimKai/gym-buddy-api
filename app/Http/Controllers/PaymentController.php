<?php

namespace App\Http\Controllers\Api;

use Stripe\Stripe;
use ErrorException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Env;

class PaymentController extends Controller
{
    public function payByStripe(){
        Stripe::setApiKey($_ENV['STRIPE_KEY']);
        try {
            $jsonStr = file_get_contents('php://input');
            $jsonObj = json_decode($jsonStr);

            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $this->calculateOrderAmount($jsonObj->items),
                'currency' => 'BAM',
                'description' => 'React Store',
                'setup_future_usage' => 'on_session'
            ]);
            
            $output = [
                'clientSecret' => $paymentIntent->client_secret,
            ];
            return response()->json($output);
            
        } catch (ErrorException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function calculateOrderAmount(array $items): int {
        foreach($items as $item){
            return $item->amount * 100;
        }
    }
}