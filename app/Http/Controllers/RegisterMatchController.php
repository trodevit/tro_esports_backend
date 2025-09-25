<?php

namespace App\Http\Controllers;

use App\Models\PaymentInfo;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterMatchController extends Controller
{
    public function show($id)
    {
        $register = PaymentInfo::where('match_id',$id)
            ->join('matches','matches.id','=','payment_infos.match_id')
            ->join('users','users.id','=','payment_infos.user_id')
            ->select('payment_infos.*','matches.*','users.*')
            ->get();
        return view('registerMatch.index',['register'=>$register]);
    }

    public function addBalance(Request $request,$id)
    {

        $data = $request->validate([
            'balance' => 'required|integer',
        ]);

        $user = User::find($id);

        $user->update($data);

        return redirect()->back()->with('success','Balance added successfully');
    }


}
