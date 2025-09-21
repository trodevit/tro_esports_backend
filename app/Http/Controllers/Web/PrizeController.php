<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Prizes;
use Illuminate\Http\Request;

class PrizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prize = Prizes::all();
        return view('prizes.index',['prizes'=>$prize]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('prizes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
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
        $prize = Prizes::find($id);

        return view('prizes.show',['prize'=>$prize]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $prize = Prizes::find($id);

        return view('prizes.edit',['prize'=>$prize]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $prize = Prizes::find($id);

        $data = $request->validate([
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
