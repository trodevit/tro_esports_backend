<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\Matches;
use App\Models\MatchHistory;
use App\Models\PaymentInfo;
use App\Models\User;
use App\Models\WithdrawMoney;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WebsiteController extends Controller
{
    public function index(){

        $matches = Matches::select([
            'id',
            'match_name',
            'category',      // br, rank, clash, dm, ko (make sure DB uses these keys or adjust in the Blade)
            'match_type',
            'map_type',
            'entry_fee',
            'grand_prize',
            'player_limit',
            'match_date',
            'match_time',
        ])
            ->orderBy('match_date')
            ->orderBy('match_time')
            ->where('is_hidden', 0)
            ->get();

        return view('welcome',['matches'=>$matches]);
    }
    public function matchList(Request $request)
    {
        $category = $request->get('category');

        $matches = $category ? Matches::where('category', $category)->get() : Matches::all();

        return response()->json($matches);
    }


    public function contactUs(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'msg' => 'required',
        ]);

        ContactUs::create($data);

        return redirect()->back();
    }

    public function contact_us()
    {
        $contact = ContactUs::all();

        return view('contact_us',['contacts'=>$contact]);
    }

    public function leaderboard()
    {
        $match = Matches::where('is_hidden',0)->get();
        return view('leaderboard',['matches'=>$match]);
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

                // userLayouts
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
                'userLayouts' => [
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

        return view('showLeader',['match'=>$match,'histories'=>$histories]);
    }

    public function myMatch()
    {
        $match = PaymentInfo::where('payment_infos.user_id',Auth::id())
            ->join('matches','matches.id','=','payment_infos.match_id')
            ->select('matches.*','matches.id as match_id','payment_infos.*')
            ->get();
        return view('myMatch',['matches'=>$match]);
    }

    public function paymentHistory()
    {
        $payment = PaymentInfo::where('user_id',Auth::id())
            ->join('matches','matches.id','=','payment_infos.match_id')
            ->select('matches.*','matches.id as match_id','payment_infos.*')
            ->get();
        return view('paymentHistory',['payments'=>$payment]);
    }

    public function matchResult()
    {
        $result = MatchHistory::where('username',Auth::user()->game_username)
            ->join('matches','matches.id','=','match_histories.match_id')
            ->select('matches.*','matches.id as match_id','match_histories.*')
            ->get();
        return view('matchResult',['matches'=>$result]);
    }

    public function withDrawMoneyStore(Request $request)
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
                return redirect()->back()->withErrors(['amount' => 'You don\'t have enough balance']);
            }


            return redirect()->back();
        }catch (\Exception $exception){
            return $this->errorResponse(null,'Something went wrong: '.$exception->getMessage(),401);
        }
    }

    public function changePassword()
    {
        return view('changePassword');
    }

    public function passwordChange(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:6|confirmed', // confirmed = needs new_password_confirmation
        ]);

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Your current password is incorrect.']);
        }

        // Update with new password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Optionally log out after change (security best practice)
        // Auth::logout();

        return back()->with('success', 'Password changed successfully!');
    }

    public function editProfile()
    {
        return view('editProfile');
    }

    public function profileUpdate(Request $request)
    {
        try {
            $user = User::find(Auth::id());

            $data = $request->validate([
                'name' => 'sometimes|nullable',
                'email' => 'sometimes|nullable|email',
                'phone' => 'sometimes|nullable',
                'game_username' => 'sometimes|nullable',
            ]);

            $user->update($data);

            return redirect()->back()->with('success', 'Profile updated successfully!');
        }
        catch (\Exception $e) {
            return $this->errorResponse(null,'Something went wrong: '.$e->getMessage(), 500);
        }
        catch (\Exception $e) {
//            dd($e->getMessage());
            return $this->errorResponse(null,'Something went wrong: '.$e->getMessage(), 500);
        }
    }

    public function checkPhone()
    {
        return view('phoneCheck');
    }

    public function phoneCheck(Request $request)
    {
        $data = $request->validate([
            'phone' => 'required|string|exists:users,phone',
        ]);

        $exists = User::where('phone', $data['phone'])->first();

        if ($exists) {
            return redirect()->route('forgot.password',['phone'=>$data['phone']]);
        }

        return $this->errorResponse(null, 'Not Matched', 400);
    }

    public function passwordForget(Request $request)
    {
        $phone = $request->query('phone');
        return view('passwordForget',['phone'=>$phone]);
    }
    public function forgotPassword(Request $request)
    {

        $data = $request->validate([
            'phone'=>'required|string|exists:users,phone',
            'password' => 'required|string|confirmed|min:6',
        ]);

        $user = User::where('phone',$data['phone'])->update(['password' => Hash::make($data['password'])]);

        return redirect()->route('home');
    }
}
