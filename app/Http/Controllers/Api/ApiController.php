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
        $rows = MatchHistory::query()
            ->join('users', 'users.game_username', '=', 'match_histories.username')
            ->join('matches','matches.id','=','match_histories.match_id')
            ->select([
                // history
                'match_histories.id as history_id',
                'match_histories.match_id as history_match_id',
                'match_histories.username',
                'match_histories.prize_money',
                'match_histories.match_kill',
                'match_histories.total_kill_money',
                'match_histories.position',
                'match_histories.created_at as history_created_at',

                // user
                'users.id as user_id',
                'users.name as user_name',
                'users.email as user_email',
                'users.phone as user_phone',
                'users.game_username as user_game_username',
                'users.balance as user_balance',

                // match
                'matches.id as match_id',
                'matches.match_name',
                'matches.category',
                'matches.entry_fee',
                'matches.player_limit',
                'matches.match_date',
                'matches.match_time',
                'matches.instructions',
                'matches.grand_prize',
                'matches.per_kill_price',
                'matches.match_type',
                'matches.map_type',
                'matches.version',
                'matches.room_details',
            ])
            ->get();

        $data = $rows->map(function ($row) {
            return [
                'history' => [
                    'id'               => (int) $row->history_id,
                    'match_id'         => (int) $row->history_match_id,
                    'username'         => $row->username,
                    'prize_money'      => (float) $row->prize_money,
                    'match_kill'       => (int) $row->match_kill,
                    'total_kill_money' => (float) $row->total_kill_money,
                    'position'         => (int) $row->position,
                    'created_at'       => $row->history_created_at,
                ],
                'user' => [
                    'id'            => (int) $row->user_id,
                    'name'          => $row->user_name,
                    'email'         => $row->user_email,
                    'phone'         => $row->user_phone,
                    'game_username' => $row->user_game_username,
                    'balance'       => (float) $row->user_balance,
                ],
                'match' => [
                    'id'            => (int) $row->match_id,
                    'match_name'    => $row->match_name,
                    'category'      => $row->category,
                    'entry_fee'     => (float) $row->entry_fee,
                    'player_limit'  => (int) $row->player_limit,
                    'match_date'    => $row->match_date,
                    'match_time'    => $row->match_time,
                    'instructions'  => $row->instructions,
                    'grand_prize'   => (float) $row->grand_prize,
                    'per_kill_price'=> (float) $row->per_kill_price,
                    'match_type'    => $row->match_type,
                    'map_type'      => $row->map_type,
                    'version'       => $row->version,
                    'room_details'  => $row->room_details,
                ],
            ];
        });

        return $this->successResponse($data, 'Match History', 200);
    }


    public function matchHistoryByID($id)
    {
        $rows = MatchHistory::query()
            ->join('users', 'users.game_username', '=', 'match_histories.username')
            ->join('matches','matches.id','=','match_histories.match_id')
            ->where('matches.id', $id) // match id
            ->select([
                // history
                'match_histories.id as history_id',
                'match_histories.match_id as history_match_id',
                'match_histories.username',
                'match_histories.prize_money',
                'match_histories.match_kill',
                'match_histories.total_kill_money',
                'match_histories.position',
                'match_histories.created_at as history_created_at',

                // user
                'users.id as user_id',
                'users.name as user_name',
                'users.email as user_email',
                'users.phone as user_phone',
                'users.game_username as user_game_username',
                'users.balance as user_balance',

                // match
                'matches.id as match_id',
                'matches.match_name',
                'matches.category',
                'matches.entry_fee',
                'matches.player_limit',
                'matches.match_date',
                'matches.match_time',
                'matches.instructions',
                'matches.grand_prize',
                'matches.per_kill_price',
                'matches.match_type',
                'matches.map_type',
                'matches.version',
                'matches.room_details',
            ])
            ->orderBy('match_histories.position', 'asc')
            ->get();

        if ($rows->isEmpty()) {
            return $this->errorResponse(null, 'No match history found', 404);
        }

        // match details (same for all rows, so take from first row)
        $match = [
            'id'            => (int) $rows[0]->match_id,
            'match_name'    => $rows[0]->match_name,
            'category'      => $rows[0]->category,
            'entry_fee'     => (float) $rows[0]->entry_fee,
            'player_limit'  => (int) $rows[0]->player_limit,
            'match_date'    => $rows[0]->match_date,
            'match_time'    => $rows[0]->match_time,
            'instructions'  => $rows[0]->instructions,
            'grand_prize'   => (float) $rows[0]->grand_prize,
            'per_kill_price'=> (float) $rows[0]->per_kill_price,
            'match_type'    => $rows[0]->match_type,
            'map_type'      => $rows[0]->map_type,
            'version'       => $rows[0]->version,
            'room_details'  => $rows[0]->room_details,
        ];

        // all player histories
        $histories = $rows->map(function ($r) {
            return [
                'history' => [
                    'id'               => (int) $r->history_id,
                    'match_id'         => (int) $r->history_match_id,
                    'username'         => $r->username,
                    'prize_money'      => (float) $r->prize_money,
                    'match_kill'       => (int) $r->match_kill,
                    'total_kill_money' => (float) $r->total_kill_money,
                    'position'         => (int) $r->position,
                    'created_at'       => $r->history_created_at,
                ],
                'user' => [
                    'id'            => (int) $r->user_id,
                    'name'          => $r->user_name,
                    'email'         => $r->user_email,
                    'phone'         => $r->user_phone,
                    'game_username' => $r->user_game_username,
                    'balance'       => (float) $r->user_balance,
                ],
            ];
        });

        $data = [
            'match'     => $match,
            'histories' => $histories,
        ];

        return $this->successResponse($data, 'Match History', 200);
    }



    public function categoryWiseMatch($category)
    {
        $category = Matches::where('category',$category)->get();

        return $this->successResponse($category,'Category wise match list',200);
    }
}
