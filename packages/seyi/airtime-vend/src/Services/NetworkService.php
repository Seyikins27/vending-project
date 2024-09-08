<?php

namespace Seyi\AirtimeVend\Services;

use Seyi\AirtimeVend\Models\NetworkProvider;
use Seyi\AirtimeVend\Models\VendingPartner;

class NetworkService 
{  
    public $name, $code;
    public function __construct(NetworkProvider $network_provider)
    {
        $this->name=$network_provider->name;
        $this->code=$network_provider->code_name;
    }
    public function switch_partner(VendingService $vending_service)
    {
       return $vending_service->request();
    }

}