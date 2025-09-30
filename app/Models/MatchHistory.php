<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchHistory extends Model
{
    protected $fillable = [
        'match_id',
        'name',
        'email',
        'mobile',
        'username',
        'prize_money',
        'match_kill',
        'total_kill_money',
        'position',
    ];
}
