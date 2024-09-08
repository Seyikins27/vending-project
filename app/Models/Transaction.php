<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable=[
       'user_wallet_id','reference_number','transaction_type','transaction_source','description','amount','other_info'
    ];

    protected $casts=[
        'other_info'=>'array'
    ];
}
