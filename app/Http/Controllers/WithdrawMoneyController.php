<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WithdrawMoney;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawMoneyController extends Controller
{
    public function index(){
        $money = WithdrawMoney::all();
        return view('withdrawMoney.index',['money'=>$money]);
    }

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

            if ($data['amount'] <= Auth::user()->balance){
                $money = WithdrawMoney::create($data);
            }
            else{
                return $this->errorResponse(null,'Your requested amount more than you balance',400);
            }


            return $this->successResponse($money,'Your request has been submitted',201);
        }catch (\Exception $exception){
            return $this->errorResponse(null,'Something went wrong: '.$exception->getMessage(),401);
        }
    }

    public function update(Request $request, $id)
    {
        $money = WithdrawMoney::find($id);

        $data = $request->validate([
            'transaction_id' => 'required',
        ]);

        $data['payment_status'] = 'approved';
        $money->update($data);
        $user = User::find($money->user_id);

        $user->balance = $user->balance - $money->amount;
        $user->save();

        return redirect()->back();
    }
}
