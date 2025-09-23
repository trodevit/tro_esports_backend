<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Matches;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $match = Matches::all();
        return view('match.index',['matches'=>$match]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('match.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'match_name'      => 'required|string|max:255',
            'category'        => 'required|string|max:100',
            'entry_fee'       => 'required|numeric|min:0',
            'player_limit'    => 'required|integer|min:1',
            'match_date'      => 'required|date',
            'match_time'      => 'required',
            'instructions'    => 'nullable|string',
            'grand_prize'     => 'required|numeric|min:0',
            'per_kill_price'  => 'required|numeric|min:0',
            'match_type'      => 'required|string|max:50',
            'map_type'        => 'required|string|max:50',
            'version'         => 'required|string|max:50',
            'room_details'    => 'nullable|string',
        ]);

        $data['match_time'] = \Carbon\Carbon::parse($request->match_time)->format('h:i A');

        $upload = Matches::create($data);

        return redirect()->back()->with('success', 'Match created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $match = Matches::find($id);

        return view('match.show',['match'=>$match]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $match = Matches::find($id);

        return view('match.edit',['match'=>$match]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $match = Matches::findOrFail($id);

        $data = $request->validate([
            'match_name'      => 'required|string|max:255',
            'category'        => 'required|string|max:100',
            'entry_fee'       => 'required|numeric|min:0',
            'player_limit'    => 'required|integer|min:1',
            'match_date'      => 'required|date',
            'match_time'      => 'required',
            'instructions'    => 'nullable|string',
            'grand_prize'     => 'required|numeric|min:0',
            'per_kill_price'  => 'required|numeric|min:0',
            'match_type'      => 'required|string|max:50',
            'map_type'        => 'required|string|max:50',
            'version'         => 'required|string|max:50',
            'room_details'    => 'nullable|string',
        ]);
        $data['match_time'] = \Carbon\Carbon::parse($request->match_time)->format('h:i A');
        $match->update($data);

        return redirect()->route('matches.index',['updated' => $match->id])->with('success', 'Match updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $match = Matches::findOrFail($id);

        $match->delete();

        return redirect()->back()->with('success', 'Match deleted successfully');
    }
}
