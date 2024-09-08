<?php
namespace Seyi\AirtimeVend;

use Exception;
use Seyi\AirtimeVend\Models\NetworkProvider;
use Seyi\AirtimeVend\Models\VendingPartner;
use Seyi\AirtimeVend\Services\NetworkService;
use Seyi\AirtimeVend\Services\TransactionService;
use Seyi\AirtimeVend\Services\VendingService;

class Airtime extends TransactionService
{
    public $network_provider;
    public $amount;

    
    public function vend(NetworkProvider $network_provider, VendingPartner $vending_partner, $data)
    {
        try{
            $vending_service= new VendingService($vending_partner, $data);
            $network_service=new NetworkService($network_provider);
            $vend_result=$network_service->switch_partner($vending_service);
            return [
                'status'=>true,
                'message'=>'Airtime Purchase successful',
                'data'=>$vend_result
            ];
        }
        catch(Exception $e)
        {
            return [
                'status'=>false,
                'message'=>'Error Purchasing Airtime'
            ];
        }
        
    }
}