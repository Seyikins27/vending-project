<?php

namespace Seyi\AirtimeVend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendingPartner extends Model
{
    use HasFactory;

    protected $fillable=[
        'name','endpoint','header_information','parameters'
    ];

    protected $casts=[
        'header_information'=>'array',
        'parameters'=>'array'
    ];
}
