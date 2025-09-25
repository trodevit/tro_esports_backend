<?php

namespace App\Http\Controllers;

use App\Models\WithdrawMoney;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawMoneyController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'amount' => 'required|numeric',
                'payment_number'=>'required',
                'payment_method'=> 'required',
            ]);

            $data['user_id'] = Auth::id();
            $data['name'] = Auth::user()->name;
            $data['email'] = Auth::user()->email;

            $money = WithdrawMoney::create($data);

            return $this->successResponse($money,'Your request has been submitted',201);
        }catch (\Exception $exception){
            return $this->errorResponse(null,'Something went wrong: '.$exception->getMessage(),401);
        }

    }
}
