<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Matches;
use App\Models\Prizes;

class ApiController extends Controller
{
    public function matches()
    {
        $match = Matches::all();

        return $this->successResponse($match,'All Matches List',200);
    }

    public function matchbyID($id){
        $match = Matches::find($id);

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
}
