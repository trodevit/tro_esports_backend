<?php

namespace App\Http\Controllers;

use App\Models\PaymentInfo;
use Illuminate\Http\Request;

class RegisterMatchController extends Controller
{
    public function show($id)
    {
        $register = PaymentInfo::where('match_id',$id)
            ->join('matches','matches.id','=','payment_info.match_id')
            ->select('payment_info.*','matches.*')
            ->first();
        return view('registerMatch.index',['register'=>$register]);
    }
}
