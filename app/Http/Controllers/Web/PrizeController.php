<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Matches;
use App\Models\Prizes;
use Illuminate\Http\Request;

class PrizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prize = Prizes::join('matches', 'prizes.match_id', '=', 'matches.id')
            ->select(
                'prizes.*',
                'matches.id as match_id',
                'matches.match_name as match_name'
            )->get();
        return view('prizes.index',['prizes'=>$prize]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $match = Matches::all();
        return view('prizes.create',['match'=>$match]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'match_id' => 'required',
            'mvp' => 'nullable|string',
            'second_winner' => 'nullable|string',
            'third_winner' => 'nullable|string',
            'fourth_winner' => 'nullable|string',
            'fifth_winner' => 'nullable|string',
            'total_grand_prize' => 'nullable|numeric',
        ]);

        Prizes::create($data);

        return redirect()->route('prizes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prize = Prizes::where('prizes.id',$id)
            ->join('matches','matches.id','=','prizes.match_id')
        ->select('prizes.*','matches.match_name')->first();

        return view('prizes.show',['prize'=>$prize]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $prize = Prizes::find($id);
        $match = Matches::all();
        return view('prizes.edit',['prize'=>$prize,'match'=>$match]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $prize = Prizes::find($id);

        $data = $request->validate([
            'match_id'=>'nullable|required',
            'mvp' => 'nullable|string',
            'second_winner' => 'nullable|string',
            'third_winner' => 'nullable|string',
            'fourth_winner' => 'nullable|string',
            'fifth_winner' => 'nullable|string',
            'total_grand_prize' => 'nullable|numeric',
        ]);

        $prize->update($data);

        return redirect()->route('prizes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prize =Prizes::find($id);

        $prize->delete();

        return redirect()->route('prizes.index');
    }
}
