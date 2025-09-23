<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\PaymentInfo;
use Carbon\Carbon;
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
        try {
            $order_id = Str::random(16);
            $data = $request->validate([
                'match_id' => 'required|exists:matches,id',
                'game_username' => 'required',
                'date'=> 'required',
                'time'=> 'required',
                'partners_name'=>'nullable|array',
            ]);

            $data['match_name'] = Matches::where('id', $data['match_id'])->value('match_name');
            $data['user_id']   = Auth::id();
            $data['email'] = Auth::user()->email;

            $data['amount'] = Matches::where('id', $data['match_id'])->value('entry_fee');

            $data['orderId'] = $order_id;

            $requestDateTime = Carbon::parse($data['date'].' '.$data['time']);

            $matchDateTime = Carbon::createFromFormat('Y-m-d H:i:s',Matches::where('id', $data['match_id'])->value('match_date').' '.Matches::where('id', $data['match_id'])->value('match_time'));
            dd($requestDateTime, $matchDateTime);

            if ($requestDateTime->greaterThanOrEqualTo($matchDateTime)) {
                return response()->json([
                    'status' => false,
                    'message' => 'You cannot register after the match has started!'
                ], 400);
            }

//        dd($data);


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

                PaymentInfo::where('orderId',$order)->update([
                    'status'=>$response->status(),
                ]);
            } elseif ($response->failed()) {
                $order = $response->metadata('order_id');

                PaymentInfo::where('orderId',$order)->update([
                    'status'=>$response->status(),
                ]);
            }
        } catch (\UddoktaPay\LaravelSDK\Exceptions\UddoktaPayException $e) {
            dd("Verification Error: " . $e->getMessage());
        }
    }
}
