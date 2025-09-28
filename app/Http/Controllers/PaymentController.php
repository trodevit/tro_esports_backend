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


                'partners_name'=>'nullable|array',
            ]);
            $data['game_username'] = Auth::user()->game_username;
            $data['match_name'] = Matches::where('id', $data['match_id'])->value('match_name');
            $data['user_id']   = Auth::id();
            $data['email'] = Auth::user()->email;
            $data['date'] = Carbon::now()->format('Y-m-d');
            $data['time'] = Carbon::now()->format('H:i:s');

            $data['amount'] = Matches::where('id', $data['match_id'])->value('entry_fee');

            $data['orderId'] = $order_id;

            Session::put('order_id',$order_id);

            $matchDate = date('Y-m-d',strtotime(Matches::where('id', $data['match_id'])->value('match_date')));
            $matchTime = date('H:i:s',strtotime(Matches::where('id', $data['match_id'])->value('match_time')));

            $currentDate = date('Y-m-d',strtotime(Carbon::now()->format('Y-m-d')));
            $currentTime = date('H:i:s',strtotime(Carbon::now()->format('H:i:s')));

            $matchDateTime = Carbon::parse("$matchDate $matchTime");
            $userDateTime  = Carbon::parse("$currentDate $currentTime");

            if ($userDateTime->gte($matchDateTime)) {
                return response()->json([
                    'status' => false,
                    'message' => 'You cannot register after the match has started!'
                ], 400);
            }
            else{
                $count = PaymentInfo::where('match_id',$data['match_id'])->count();
                $playerLimit = Matches::find($data['match_id']);

                if ($count>$playerLimit->player_limit) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Room is full you cannot register'
                    ], 400);
                }
            }

//        dd($data);

            $baseURL = 'https://payment.trodevit.com/trodevit/api/checkout-v2';
            $apiKey = 'MHvZvqX6UY7Vw4AcrWjwGALF1VKlOQxJgaK2uuo6';

            $body = [
                'full_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'amount' => $data['amount'],
                'metadata' => json_encode($data['orderId']),
                'redirect_url' => route('uddoktapay.verify'),
                'cancel_url' => route('uddoktapay.cancel')
            ];

            dd($body);

            $response = Http::withHeaders([
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'RT-UDDOKTAPAY-API-KEY'      => $apiKey,
            ])->post($baseURL,[$body]);

            if ($response->successful()){
                dd($response->json());
            }
            else{
                dd($response->json());
            }
//            $checkoutRequest = CheckoutRequest::make()
//                ->setFullName(Auth::user()->name)
//                ->setEmail(Auth::user()->email)
//                ->setAmount(Matches::where('id', $data['match_id'])->value('entry_fee'))
//                ->addMetadata('order_id', $order_id)
//                ->setRedirectUrl(route('uddoktapay.verify'))
//                ->setCancelUrl(route('uddoktapay.cancel'))
//                ->setWebhookUrl(route('uddoktapay.ipn'));
//
//            $response = $this->uddoktapay()->checkout($checkoutRequest);
//
//
//            if ($response->failed()) {
//                dd($response->message());
//            }
            $data['status']='pending';

            $payment = PaymentInfo::create($data);
//            dd($payment);
            return response()->json([
                'status'=>true,
                'message'=>'Checking Out',
                'url'=>$response->paymentURL()
            ]);
        } catch (\UddoktaPay\LaravelSDK\Exceptions\UddoktaPayException $e) {
            dd("Initialization Error: " . $e->getMessage());
        }
        catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function verify(Request $request)
    {
        try {
            $response = $this->uddoktapay()->verify($request);

            if ($response->success()) {
                $order = $response->metadata('order_id');

               $payment = PaymentInfo::where('orderId',$order)->update([
                    'payment_number'=>$response->senderNumber(),
                    'method'=>$response->paymentMethod(),
                    'transaction_id'=>$response->transactionId(),
                    'status'=>$response->status(),
                ]);

               $match = PaymentInfo::where('orderId',$order)
                   ->join('matches','matches.id','=','payment_infos.match_id')
                   ->select('payment_infos.*','matches.room_details')
                   ->get();

                return response()->json([$match]);

            } elseif ($response->pending()) {
                $order = $response->metadata('order_id');

                PaymentInfo::where('orderId',$order)->delete();;
            } elseif ($response->failed()) {
                $order = $response->metadata('order_id');

                PaymentInfo::where('orderId',$order)->delete();
            }
        } catch (\UddoktaPay\LaravelSDK\Exceptions\UddoktaPayException $e) {
            dd("Verification Error: " . $e->getMessage());
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
