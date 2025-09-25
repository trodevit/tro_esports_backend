<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawMoney extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'name',
        'email',
        'payment_method',
        'payment_status',
        'payment_number',
        'transaction_id'
    ];
}
