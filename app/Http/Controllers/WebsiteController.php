<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use Illuminate\Http\Request;

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
            ->get();

        return view('welcome',['matches'=>$matches]);
    }
    public function matchList(Request $request)
    {
        $category = $request->get('category');

        $matches = $category ? Matches::where('category', $category)->get() : Matches::all();

        return response()->json($matches);
    }
}
