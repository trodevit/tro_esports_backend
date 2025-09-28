<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Matches;
use App\Models\PaymentInfo;
use App\Models\Prizes;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function matches()
    {
        $match = Matches::all();

        return $this->successResponse($match,'All Matches List',200);
    }

    public function matchbyID($id)
    {
        $match = Matches::find($id);

        if (!$match) {
            return response()->json([
                'status' => false,
                'message' => 'Match not found!'
            ], 404);
        }

        $nowDate = now()->format('Y-m-d');
        $nowTime = now()->format('H:i:s');

        $matchDate = date('Y-m-d', strtotime($match->match_date));
        $matchTime = date('H:i:s', strtotime($match->match_time));

        $matchDateTime = Carbon::parse("$matchDate $matchTime");
        $userDateTime  = Carbon::parse("$nowDate $nowTime");

        // Check if match has started
        if ($userDateTime->gte($matchDateTime)) {
            return response()->json([
                'status' => false,
                'message' => 'You cannot register after the match has started!'
            ], 400);
        }

        // Count how many players are registered
        $count = PaymentInfo::where('match_id', $match->id)->count();
        $playerLimit = $match->player_limit - $count; // remaining slots

        // Check if the user has purchased this match
        $purchased = PaymentInfo::where('match_id', $match->id)
            ->where('user_id', auth()->id()) // check logged-in user
            ->where('status', 'success')     // only successful payments
            ->exists();

        // Prepare response data
        $data = [
            'match' => $match,
            'remaining_slots' => $playerLimit,
        ];

        // Only show room details if purchased
        if ($purchased) {
            $data['room_details'] = [
                'room_details'   => $match->room_details,
//                'room_pass' => $match->room_password,
            ];
        }

        return $this->successResponse(
            $data,
            $match->match_name . ' Match Details',
            200
        );
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

    public function emptySlot($id){
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
            return response()->json([
                'status' => false,
                'message' => 'You cannot register after the match has started!'
            ], 400);
        }
        else{
            $count = PaymentInfo::where('match_id',$match->id)->count();
            $playerLimit = $count - $match->player_limit;

            return $this->successResponse($playerLimit,'Total Free Slots',200);
        }

    }
}
