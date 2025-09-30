<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Matches;
use App\Models\MatchHistory;
use App\Models\PaymentInfo;
use App\Models\Prizes;
use App\Models\WithdrawMoney;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function matches()
    {
        $match = Matches::all();

        return $this->successResponse($match,'All Matches List',200);
    }

    public function matchbyID($id){
        $match = Matches::find($id);

        $nowDate = now()->format('Y-m-d');
        $nowTime = now()->format('H:i:s');

        $matchDate = date('Y-m-d',strtotime(Matches::find($id)->value('match_date')));
        $matchTime = date('H:i:s',strtotime(Matches::find($id)->value('match_time')));

        $currentDate = date('Y-m-d',strtotime($nowDate));
        $currentTime = date('H:i:s',strtotime($nowTime));

        $matchDateTime = Carbon::parse("$matchDate $matchTime");
        $userDateTime  = Carbon::parse("$currentDate $currentTime");


        if ($userDateTime->gte($matchDateTime)) {
            $purchaced = PaymentInfo::where('match_id',$match->id)->where('user_id',Auth::id())->exists();
            if (!$purchaced){
                $match->room_details = null;
                $match->isPayment = false;
            }
            else{
                $match->isPayment = true;
            }
            $count = PaymentInfo::where('match_id',$match->id)->count();
            $playerLimit = $match->player_limit - $count;
            $match->slot_free = $playerLimit;

            $progress = 0;
            if ($match->player_limit > 0) {
                $progress = (($count / $match->player_limit) * 100);
            }
            $match->progress = $progress;
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'You cannot register after the match has started!'
            ], 400);
        }

        return $this->successResponse($match,$match->match_name.' Match Details',200);
    }

    public function prizeTools()
    {
        $prize = Prizes::all();

        return $this->successResponse($prize,'All Prizes List',200);
    }

    public function prizebyID($id){
        $prize = Prizes::find($id);

        return $this->successResponse($prize,'Prize Details',200);
    }

    public function withdrawList(){
        $money = WithdrawMoney::where('user_id',Auth::id())->latest()->get();

        return $this->successResponse($money,'Your Withdraw List',200);
    }

    public function matchHistory()
    {
        $history = MatchHistory::join('users', 'users.game_username', '=', 'match_histories.username')
            ->select('match_histories.*', 'users.*')->get();

        return $this->successResponse($history,'Match History',200);
    }

    public function categoryWiseMatch($category)
    {
        $category = Matches::where('category',$category)->get();

        return $this->successResponse($category,'Category wise match list',200);
    }
}
