<?php

namespace App\Http\Controllers;

use App\Models\PaymentInfo;
use Illuminate\Http\Request;

class RegisterMatchController extends Controller
{
    public function show($id)
    {
        $register = PaymentInfo::where('match_id',$id)
            ->join('matches','matches.id','=','payment_infos.match_id')
            ->select('payment_infos.*','matches.*')
            ->get();
        return view('registerMatch.index',['register'=>$register]);
    }
}
