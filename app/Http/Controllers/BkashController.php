<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class BkashController extends Controller
{
    protected $token;

    public function getToken(Request $request)
    {
        $baseURL = 'https://tokenized.pay.bka.sh/v1.2.0-beta';
        $username = '01777614837';
        $password = '$Jiq{H:1m+3';
        $appKey = 'IhoSMLt5FuagMTCxtVWRJ5sftc';
        $appPassword = 'vCtNEcEe4GpwAwNMpb6oIPW5omVaPx0njOcoiAUtL29O0HemOmai';

        $sandBoxURL = 'https://tokenized.sandbox.bka.sh/v1.2.0-beta';
        $sandBoxUsername = 'sandboxTokenizedUser02';
        $sandBoxPassword = 'sandboxTokenizedUser02@12345';
        $sandBoxAppKey = '4f6o0cjiki2rfm34kfdadl1eqq';
        $sandBoxAppPassword = '2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b';

        $body = [
            'app_key' => $appKey,
            'app_secret' => $appPassword,
        ];
        $sandBoxBody = [
            'app_key' => $sandBoxAppKey,
            'app_secret' => $sandBoxAppPassword,
        ];

        try {
            if (env('APP_ENV') === 'production') {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'username' => $username,
                    'password' => $password,
                ])->post($baseURL . '/tokenized/checkout/token/grant', $body);
            } else {
                $response = Http::withoutVerifying()->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'username' => $sandBoxUsername,
                    'password' => $sandBoxPassword,
                ])->post($sandBoxURL . '/tokenized/checkout/token/grant', $sandBoxBody);
            }


            if ($response->successful()) {
                $this->token = $response->json('id_token');
                $refreshToken = $response->json('refresh_token');
                Session::put('token', $this->token);
                Session::put('refresh_token', $refreshToken);
                return response()->json([
                    'success' => true,
                    'data' => $response->json()
                ],200);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => $response->json('message')
                ]);
            }
        }
        catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function queryBalance(Request $request)
    {
        $token = Session::get('token'); // saved id_token
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token not provided',
            ], 400);
        }
        if (stripos($token, 'Bearer ') === 0) { // must be raw token
            $token = substr($token, 7);
        }

//        dd($token);

        $baseURL = 'https://tokenized.pay.bka.sh/v1.2.0-beta';
        $username = '01777614837';
        $password = '$Jiq{H:1m+3';
        $appKey = 'IhoSMLt5FuagMTCxtVWRJ5sftc';
        $appPassword = 'vCtNEcEe4GpwAwNMpb6oIPW5omVaPx0njOcoiAUtL29O0HemOmai';

        $sandBoxURL = 'https://tokenized.sandbox.bka.sh/v1.2.0-beta';
        $sandBoxUsername = 'sandboxTokenizedUser02';
        $sandBoxPassword = 'sandboxTokenizedUser02@12345';
        $sandBoxAppKey = '4f6o0cjiki2rfm34kfdadl1eqq';
        $sandBoxAppPassword = '2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b';

        if (env('APP_ENV') === 'production') {
            $url   = $baseURL . '/checkout/payment/organizationBalance';
            $appId = $appKey;
            $response = Http::withHeaders([
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'Authorization' => $token,
                'X-App-Key'     => $appId,
            ])->get($url);
        } else {
            $url   = $sandBoxURL . '/tokenized/checkout/payment/b2cPayment';
            $appId = $sandBoxAppKey;
            $credential = [
                'username' => $sandBoxUsername,
                'password' => $sandBoxPassword,
            ];

            $response = Http::withoutVerifying()->withHeaders([
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'Authorization' => $token,
                'X-App-Key'     => $appId,
//                'Date' => Carbon::now('Asia/Dhaka')->format('H:i:s'),
//                'Credential'=>$credential
            ])->post($url,[
                'amount' => 1,
                'currency' => 'BDT',
                'merchantInvoiceNumber'=>Str::random(16),
                'receiverMSISDN' => '01642889275'
            ]);
        }

        // Make request


        return $response->json();
    }

}
