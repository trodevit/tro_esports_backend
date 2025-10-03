<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MatchHistory;
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
            ->select('payment_infos.*','matches.*','users.*','matches.id as match_id')
            ->get();

        $match = MatchHistory::where('match_id',$id)->join('users','users.game_username','=','match_histories.username')->exists();
        return view('registerMatch.index',['register'=>$register,'match'=>$match]);
    }

    public function addBalance(Request $request,$id)
    {

        $data = $request->validate([
            'balance' => 'required|integer',
        ]);

        $user = User::find($id);
        $balance = $user->balance+$data['balance'];
        $data['balance'] = $balance;
        $user->update($data);

        return redirect()->back()->with('success','Balance added successfully');
    }


}
