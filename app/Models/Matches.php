<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    protected $fillable = [
        'match_name',
        'category',
        'entry_fee',
        'player_limit',
        'match_date',
        'match_time',
        'instructions',
        'grand_prize',
        'per_kill_price',
        'match_type',
        'map_type',
        'version',
        'room_details',
        'is_hidden'
    ];
}
