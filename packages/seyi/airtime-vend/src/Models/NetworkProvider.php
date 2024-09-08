<?php

namespace Seyi\AirtimeVend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkProvider extends Model
{
    use HasFactory;

    protected $fillable=[
        'name','code_name','commission'
    ];
}
