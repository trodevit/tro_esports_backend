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

    public function getToken()
    {
        $username='01777614837';
        $password='$Jiq{H:1m+3';
        $appKey='IhoSMLt5FuagMTCxtVWRJ5sftc';
        $appSecret='vCtNEcEe4GpwAwNMpb6oIPW5omVaPx0njOcoiAUtL29O0HemOmai';
        $baseURL='https://tokenized.pay.bka.sh/v1.2.0-beta';

        $sandBoxURL = 'https://tokenized.sandbox.bka.sh/v1.2.0-beta';
        $sandBoxUsername = 'sandboxTokenizedUser02';
        $sandBoxPassword = 'sandboxTokenizedUser02@12345';
        $sandBoxAppKey = '4f6o0cjiki2rfm34kfdadl1eqq';
        $sandBoxAppPassword = '2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b';

        if (env('APP_ENV') === 'production') {
            $response = Http::withHeaders([
                'username' => $username, 'password' => $password,
            ])->post($baseURL . '/tokenized/checkout/token/grant', [
                'app_key' => $appKey, 'app_secret' => $appSecret,
            ]);
        }else{
            $response = Http::withoutVerifying()->withHeaders([
                'username' => $sandBoxUsername, 'password' => $sandBoxPassword,
            ])->post($sandBoxURL . '/tokenized/checkout/token/grant', [
                'app_key' => $sandBoxAppKey, 'app_secret' => $sandBoxAppPassword,
            ]);
        }

        if ($response->successful()) {
            Session::put('token', $response->json('id_token'));
        }
        dd($response->json());
    }

    public function createAgreement()
    {
        $token = Session::get('token');
        if (!$token) {
            return response()->json([
                'message' => 'Token is invalid.',
            ]);
        }

        $username='01777614837';
        $password='$Jiq{H:1m+3';
        $appKey='IhoSMLt5FuagMTCxtVWRJ5sftc';
        $appSecret='vCtNEcEe4GpwAwNMpb6oIPW5omVaPx0njOcoiAUtL29O0HemOmai';
        $baseURL='https://tokenized.pay.bka.sh/v1.2.0-beta';

        $sandBoxURL = 'https://tokenized.sandbox.bka.sh/v1.2.0-beta';
        $sandBoxUsername = 'sandboxTokenizedUser02';
        $sandBoxPassword = 'sandboxTokenizedUser02@12345';
        $sandBoxAppKey = '4f6o0cjiki2rfm34kfdadl1eqq';
        $sandBoxAppPassword = '2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b';

        if (env('APP_ENV') === 'production') {
            $response = Http::withHeaders([
                'Authorization' => $token,
                'X-App-Key' => $appKey,
            ])->post($baseURL . '/tokenized/checkout/create', [
                'mode' => '0000',
                'payerReference' => '01642889275',
                'callbackURL' => route('excute.agreement', []),
                'amount' => 1,
                'currency' => 'BDT',
                'intent' => 'sale',
                'merchantInvoiceNumber' => Str::random(10),
            ]);
        }else{
            $response = Http::withHeaders([
                'Authorization' => $token,
                'X-App-Key' => $sandBoxAppKey,
            ])->post($sandBoxURL . '/tokenized/checkout/create', [
                'mode' => '0000',
                'payerReference' => '01642889275',
                'callbackURL' => route('excute.agreement', []),
                'amount' => 1,
                'currency' => 'BDT',
                'intent' => 'sale',
                'merchantInvoiceNumber' => Str::random(10),
            ]);
        }

        if ($response->successful()) {
           return redirect()->away($response->json('bkashURL'));

        }
        dd($response->json());
    }

    public function executeAgreement(Request $request)
    {
        $token = Session::get('token');
        $paymentId = $request->query('paymentID');
//        dd($token, $paymentId);
        if (!$token && !$paymentId) {
            return response()->json([
                'message' => 'Token is invalid.',
            ]);
        }

        $username='01777614837';
        $password='$Jiq{H:1m+3';
        $appKey='IhoSMLt5FuagMTCxtVWRJ5sftc';
        $appSecret='vCtNEcEe4GpwAwNMpb6oIPW5omVaPx0njOcoiAUtL29O0HemOmai';
        $baseURL='https://tokenized.pay.bka.sh/v1.2.0-beta';

        $sandBoxURL = 'https://tokenized.sandbox.bka.sh/v1.2.0-beta';
        $sandBoxUsername = 'sandboxTokenizedUser02';
        $sandBoxPassword = 'sandboxTokenizedUser02@12345';
        $sandBoxAppKey = '4f6o0cjiki2rfm34kfdadl1eqq';
        $sandBoxAppPassword = '2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b';

        if (env('APP_ENV') === 'production') {
            $response = Http::withHeaders([
                'Authorization' => $token,
                'X-App-Key' => $appKey,
            ])->post($baseURL . '/tokenized/checkout/execute', [
                'paymentID' => $paymentId
            ]);
        }
        else{
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => $token,
                'X-App-Key' => $sandBoxAppKey,
            ])->post($sandBoxURL . '/tokenized/checkout/execute', [
                'paymentID' => $paymentId
            ]);
        }
        if ($response->successful()) {
            $response->json();
        }
        dd($response->json());
    }

    public function createPayment(Request $request)
    {
        $agreement = Session::get('agreementID');
    }

    public function queryBalance()
    {
        $token = Session::get('token');
        if (!$token) {
            return response()->json([
                'message' => 'Token is invalid.',
            ]);
        }

        $username='01777614837';
        $password='$Jiq{H:1m+3';
        $appKey='IhoSMLt5FuagMTCxtVWRJ5sftc';
        $appSecret='vCtNEcEe4GpwAwNMpb6oIPW5omVaPx0njOcoiAUtL29O0HemOmai';
        $baseURL='https://tokenized.pay.bka.sh/v1.2.0-beta';

        $sandBoxURL = 'https://tokenized.sandbox.bka.sh/v1.2.0-beta';
        $sandBoxUsername = 'sandboxTokenizedUser02';
        $sandBoxPassword = 'sandboxTokenizedUser02@12345';
        $sandBoxAppKey = '4f6o0cjiki2rfm34kfdadl1eqq';
        $sandBoxAppPassword = '2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b';

        if (env('APP_ENV') === 'production') {

            $method = 'GET';
            $service = 'execute-api';
            $host = parse_url($baseURL, PHP_URL_HOST);
            $region = 'ap-southeast-1';
            $uri = parse_url($baseURL, PHP_URL_PATH);
            $t = gmdate('Ymd\THis\Z');
            $date = substr($t, 0, 8);

            $canonicalUri = $uri;
            $canonicalQueryString = '';
            $canonicalHeaders = "host:{$host}\n";
            $signedHeaders = 'host';
            $payloadHash = hash('sha256', '');
            $canonicalRequest = "{$method}\n{$canonicalUri}\n{$canonicalQueryString}\n{$canonicalHeaders}\n{$signedHeaders}\n{$payloadHash}";

            $algorithm = 'AWS4-HMAC-SHA256';
            $credentialScope = "{$date}/{$region}/{$service}/aws4_request";
            $stringToSign = "{$algorithm}\n{$t}\n{$credentialScope}\n" . hash('sha256', $canonicalRequest);

            // derive signing key
            $kDate = hash_hmac('sha256', $date, "AWS4{$appSecret}", true);
            $kRegion = hash_hmac('sha256', $region, $kDate, true);
            $kService = hash_hmac('sha256', $service, $kRegion, true);
            $kSigning = hash_hmac('sha256', "aws4_request", $kService, true);
            $signature = hash_hmac('sha256', $stringToSign, $kSigning);

            $authorizationHeader = "{$algorithm} Credential={$appKey}/{$credentialScope}, SignedHeaders={$signedHeaders}, Signature={$signature}";


            $response = Http::withHeaders([
                'Authorization' => $authorizationHeader,
                'X-App-Key' => $appKey,
                'X-Amz-Date' =>$t
            ])->post($baseURL . '/tokenized/checkout/payment/organizationBalance');
        }
        else{
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => $token,
                'X-App-Key' => $sandBoxAppKey,
            ])->post($sandBoxURL . '/tokenized/checkout/payment/organizationBalance');
        }

        dd($response->json());
    }

}
