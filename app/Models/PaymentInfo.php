<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentInfo extends Model
{
    protected $fillable = [
        'user_id',
        'game_username',
        'payment_number',
        'method',
        'email',
        'amount',
        'status',
        'transaction_id',
        'date',
        'time',
        'match_id',
        'match_name'
    ];
}
