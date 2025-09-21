<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index(){
        return view('welcome');
    }
    public function matchList(Request $request)
    {
        $category = $request->get('category');

        $matches = $category ? Matches::where('category', $category)->get() : Matches::all();

        return response()->json($matches);
    }
}
