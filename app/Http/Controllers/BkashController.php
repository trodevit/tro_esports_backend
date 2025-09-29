<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

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
                ])->post($baseURL . '/checkout/token/grant', $body);
            } else {
                $response = Http::withoutVerifying()->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'username' => $sandBoxUsername,
                    'password' => $sandBoxPassword,
                ])->post($sandBoxURL . '/checkout/token/grant', $sandBoxBody);
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

    public function queryBalance(Request $request){
        $token = Session::get('token');
        if (!$token){
            return response()->json([
                'success' => false,
                'message' => 'Token not provided',
            ],400);
        }

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

       $refresh = Session::get('refresh_token');

        if (env('APP_ENV') === 'production') {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'authorization' => $token,
                'x-app-key' => $appKey
            ])->post($baseURL . '/checkout/payment/organizationBalance');
        } else {
            $response = Http::withoutVerifying()->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'authorization' => $token,
                'x-app-key' =>$sandBoxAppKey
            ])->post($sandBoxURL . '/checkout/payment/organizationBalance');
        }

        dd($response->json());

    }
}
