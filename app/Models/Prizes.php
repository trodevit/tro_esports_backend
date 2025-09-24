<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prizes extends Model
{
    use HasFactory;
    protected $fillable = [
        'match_id',
        'mvp',
        'second_winner',
        'third_winner',
        'fourth_winner',
        'fifth_winner',
        'total_grand_prize'
    ];
}
