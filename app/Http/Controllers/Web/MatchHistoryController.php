<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MatchHistory;
use App\Models\User;
use Illuminate\Http\Request;

class MatchHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $history = MatchHistory::join('users', 'users.game_username', '=', 'match_histories.username')
        ->select('match_histories.*', 'users.*')->get();

        return view('matchHistory.index', ['histories' => $history]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'match_id'=>'required',
            'name'=>'required',
            'email'=>'required',
            'mobile'=>'required',
            'username'=>'required',
            'position'=>'required',
            'match_kill'=>'required|numeric',
            'prize_money'=>'required|numeric',
        ]);

        $data['total_kill_money'] = $request->input('per_kill') * $data['match_kill'];

//        dd($data);

        MatchHistory::create($data);

        $user = User::find($request->input('user_id'));
        $user->balance = $user->balance+$data['total_kill_money']+$data['prize_money'];
        $user->save();

        return redirect()->back()->with('success', 'Match History Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
