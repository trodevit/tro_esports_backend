<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\PaymentInfo;
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

            $data['amount'] = Matches::where('id', $data['match_id'])->value('entry_fee');

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
            $apiKey = 'jYX9XBfxSxeAmRQZh3PqjvNFxm1quLqnyi7athqe';
            $email = Auth::user()->email;
            $body = [
                'full_name' => Auth::user()->name,
                'email' => $email,
                'amount' => $data['amount'],
                'metadata' => ['orderId' => $order_id, 'user_id' => Auth::id()],
                'redirect_url' => route('uddoktapay.verify'),
                'cancel_url' => route('uddoktapay.cancel')
            ];

//            dd($body);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'RT-UDDOKTAPAY-API-KEY' => $apiKey,
            ])->post($baseURL, $body);

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
        $baseURL = 'https://payment.trodevit.com/troesports/api/verify-payment';
        $apiKey = 'jYX9XBfxSxeAmRQZh3PqjvNFxm1quLqnyi7athqe';
        $email = Auth::user()->email;
        $body = [
            'full_name' => Auth::user()->name,
            'email' => $email,
            'amount' => $data['amount'],
            'metadata' => ['orderId' => $order_id, 'user_id' => Auth::id()],
            'redirect_url' => route('uddoktapay.verify'),
            'cancel_url' => route('uddoktapay.cancel')
        ];

//            dd($body);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'RT-UDDOKTAPAY-API-KEY' => $apiKey,
        ])->post($baseURL, $body);

        if ($response->successful()) {
            $url = $response->json('payment_url');
            return $this->successResponse($url, 'Checking Out', 200);
        } else {
            return $this->errorResponse($response->json('message'), 'Something went wrong', 400);
        }
    }

    public function paymentHistory()
    {
        $payment = PaymentInfo::where('user_id',Auth::id())->get();

        return $this->successResponse($payment,'Your Payment History',200);
    }

    public function cancel( Request $request)
    {
        $order = Session::get('order_id');

        PaymentInfo::where('orderId',$order)->delete();

        return $this->successResponse(null,'Payment Cancelled',200);
    }
}
