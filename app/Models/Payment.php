<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'order_id',
        'payment_id',
        'payer_id',
        'payer_email',
        'amount',
        'currency',
        'payment_method',

    ];
}
