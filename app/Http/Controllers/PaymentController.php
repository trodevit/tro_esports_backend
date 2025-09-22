<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use UddoktaPay\LaravelSDK\Requests\CheckoutRequest;
use UddoktaPay\LaravelSDK\UddoktaPay;

class PaymentController extends Controller
{
    public function uddoktapay()
    {
        return UddoktaPay::make(env('UDDOKTAPAY_API_KEY'), env('UDDOKTAPAY_API_URL'));
    }
    public function paymentInit(Request $request)
    {
        $order_id = Str::random(16);
        $data = $request->validate([
            'match_id' => 'required|exists:matches,id',
            'game_username' => 'required',
            'date'=> 'required',
            'time'=> 'required',
        ]);

        $data['match_name'] = Matches::where('id', $data['match_id'])->value('match_name');
        $data['user_id']   = Auth::id();

        $amount = Matches::where('id', $data['match_id'])->value('entry_fee');

//        dd($data);

        try {
            $checkoutRequest = CheckoutRequest::make()
                ->setFullName(Auth::user()->name)
                ->setEmail(Auth::user()->email)
                ->setAmount(Matches::where('id', $data['match_id'])->value('entry_fee'))
                ->addMetadata('order_id', $order_id)
                ->setRedirectUrl(route('uddoktapay.verify'))
                ->setCancelUrl(route('uddoktapay.cancel'))
                ->setWebhookUrl(route('uddoktapay.ipn'));

            $response = $this->uddoktapay()->checkout($checkoutRequest);


            if ($response->failed()) {
                dd($response->message());
            }

            return redirect($response->paymentURL());
        } catch (\UddoktaPay\LaravelSDK\Exceptions\UddoktaPayException $e) {
            dd("Initialization Error: " . $e->getMessage());
        }
    }

    public function verify(Request $request)
    {
        try {
            $response = $this->uddoktapay()->verify($request);

            if ($response->success()) {
                $order = $response->metadata('order_id');
                dd($response->toArray()); // Handle success
            } elseif ($response->pending()) {
                // Handle pending status
            } elseif ($response->failed()) {
                // Handle failure
            }
        } catch (\UddoktaPay\LaravelSDK\Exceptions\UddoktaPayException $e) {
            dd("Verification Error: " . $e->getMessage());
        }
    }
}
