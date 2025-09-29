<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\PaymentInfo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use UddoktaPay\LaravelSDK\Requests\CheckoutRequest;
use UddoktaPay\LaravelSDK\UddoktaPay;

class PaymentController extends Controller
{
    public function index()
    {
        $payment = PaymentInfo::latest()->paginate(15);
        return view('payment.index',['payments'=>$payment]);
    }
    public function uddoktapay()
    {
        return UddoktaPay::make(env('UDDOKTAPAY_API_KEY'), env('UDDOKTAPAY_API_URL'));
    }
    public function paymentInit(Request $request)
    {
        try {
            $order_id = Str::random(16);
            $data = $request->validate([
                'match_id' => 'required|exists:matches,id',
                'partners_name' => 'nullable|array',
            ]);

            $check = Matches::where('id', $data['match_id'])->first();

            if ($check->match_type == 'Duo') {
                $data['amount'] = Matches::where('id', $data['match_id'])->value('entry_fee') * 2;
            }elseif ($check->match_type == '4v4'){
                $data['amount'] = Matches::where('id', $data['match_id'])->value('entry_fee') * 4;
            }else{
                $data['amount'] = Matches::where('id', $data['match_id'])->value('entry_fee');
            }

            Session::put('order_id', $order_id);
            Session::put('user_id',Auth::id());

            $matchDate = date('Y-m-d', strtotime(Matches::where('id', $data['match_id'])->value('match_date')));
            $matchTime = date('H:i:s', strtotime(Matches::where('id', $data['match_id'])->value('match_time')));

            $currentDate = date('Y-m-d', strtotime(Carbon::now()->format('Y-m-d')));
            $currentTime = date('H:i:s', strtotime(Carbon::now()->format('H:i:s')));

            $matchDateTime = Carbon::parse("$matchDate $matchTime");
            $userDateTime = Carbon::parse("$currentDate $currentTime");

            if ($userDateTime->gte($matchDateTime)) {
                return response()->json([
                    'status' => false,
                    'message' => 'You cannot register after the match has started!'
                ], 400);
            } else {
                $count = PaymentInfo::where('match_id', $data['match_id'])->count();
                $playerLimit = Matches::find($data['match_id']);

                if ($count > $playerLimit->player_limit) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Room is full you cannot register'
                    ], 400);
                }
            }

            $baseURL = 'https://payment.trodevit.com/troesports/api/checkout';
            $sandBoxURL = 'https://sandbox.uddoktapay.com/api/checkout-v2';
            $apiKey = 'jYX9XBfxSxeAmRQZh3PqjvNFxm1quLqnyi7athqe';
            $sandBoxApi = '982d381360a69d419689740d9f2e26ce36fb7a50';
            $email = Auth::user()->email;
            $body = [
                'full_name' => Auth::user()->name,
                'email' => $email,
                'amount' => $data['amount'],
                'metadata' => [
                    'match_id' =>$data['match_id'],
                    'partners_name'=>$data['partners_name'],
                    'user_id' => Auth::id()
                ],
                'redirect_url' => route('uddoktapay.verify',[],true),
                'return_type' => 'GET',
                'cancel_url' => route('uddoktapay.cancel',[],true)
            ];

            if (env('APP_ENV') == 'production') {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'RT-UDDOKTAPAY-API-KEY' => $apiKey,
                ])->post($baseURL, $body);
            }else{
                $response = Http::withoutVerifying()->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'RT-UDDOKTAPAY-API-KEY' => $sandBoxApi,
                ])->post($sandBoxURL, $body);
            }

            if ($response->successful()) {
                $url = $response->json('payment_url');
                return $this->successResponse($url, 'Checking Out', 200);
            } else {
                return $this->errorResponse($response->json('message'), 'Something went wrong', 400);
            }

        }
        catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(), 'Something went wrong', 400);
        }
    }

    public function verify(Request $request)
    {
        try {
            $baseURL = 'https://payment.trodevit.com/troesports/api/verify-payment';
            $apiKey = 'jYX9XBfxSxeAmRQZh3PqjvNFxm1quLqnyi7athqe';
            $sandBoxURL = 'https://sandbox.uddoktapay.com/api/verify-payment';
            $sandBoxApi = '982d381360a69d419689740d9f2e26ce36fb7a50';
            $body = ['invoice_id'=>$request->query('invoice_id')];

            if (env('APP_ENV') == 'production') {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'RT-UDDOKTAPAY-API-KEY' => $apiKey,
                ])->post($baseURL, $body);
            } else {
                $response = Http::withoutVerifying()->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'RT-UDDOKTAPAY-API-KEY' => $sandBoxApi,
                ])->post($sandBoxURL, $body);
            }

            if ($response->successful()) {
                $userID = $response->json(['metadata','user_id']);
                $user_id = User::where('id',$userID)->first();
                $data = $response->json();
                $match = Matches::where('id',$response->json(['metadata','match_id']))->first();
                $payment = PaymentInfo::create([
                    'user_id'=>$userID,
                    'game_username'=>$user_id->game_username,
                    'payment_number'=>$data['sender_number'],
                    'method'=>$data['payment_method'],
                    'email'=>$data['email'],
                    'amount'=>$data['amount'],
                    'status'=>$data['status'],
                    'transaction_id'=>$data['transaction_id'],
                    'date'=>Carbon::now('Asia/Dhaka')->format('Y-m-d'),
                    'time'=>Carbon::now('Asia/Dhaka')->format('H:i:s'),
                    'match_id'=>$response->json(['metadata','match_id']),
                    'match_name'=>$match->match_name,
                    'orderId'=>$data['invoice_id'],
                    'partners_name'=>$response->json(['metadata','partners_name'])
                ]);
                return $this->successResponse($payment, 'Payment Successfully', 201);
            } else {
                return $this->errorResponse($response->json('message'), 'Something went wrong', 400);
            }
        }
        catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(), 'Something went wrong', 400);
        }
    }

    public function paymentHistory()
    {
        $payment = PaymentInfo::where('user_id',Auth::id())->get();

        return $this->successResponse($payment,'Your Payment History',200);
    }

    public function refund(Request $request)
    {
        $baseURL = 'https://payment.trodevit.com/troesports/api/refund-payment';
        $apiKey = 'jYX9XBfxSxeAmRQZh3PqjvNFxm1quLqnyi7athqe';
        $sandBoxURL = 'https://sandbox.uddoktapay.com/api/refund-payment';
        $sandBoxApi = '982d381360a69d419689740d9f2e26ce36fb7a50';
        $body = [
            'transaction_id'=>$request->input('transaction_id'),
            'payment_method'=>$request->input('method'),
            'amount'=>$request->input('amount'),
            'product_name'=>$request->input('match_name'),
            'reason'=>$request->input('reason')
        ];


        if (env('APP_ENV') == 'production') {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'RT-UDDOKTAPAY-API-KEY' => $apiKey,
            ])->post($baseURL, $body);
        } else {
            $response = Http::withoutVerifying()->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'RT-UDDOKTAPAY-API-KEY' => $sandBoxApi,
            ])->post($sandBoxURL, $body);
        }

        if ($response->successful()) {
            PaymentInfo::where('transaction_id',$body['transaction_id'])
                ->update([
                    'status'=>'refunded',
                    'refund_amount' => $body['amount'],
                    'refund_reason'=>$body['reason']
                ]);
            return $this->successResponse($body, 'Refund Successfully', 200);
        }
        else {
            dd($response->json());
        }
    }

    public function cancel( Request $request)
    {
        return $this->successResponse($request->query('invoice_id'),'Payment Cancel',200);
    }
}
