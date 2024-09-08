<?php
namespace Seyi\AirtimeVend;

use App\Models\UserWallet;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Seyi\AirtimeVend\Models\NetworkProvider;
use Seyi\AirtimeVend\Models\VendingPartner;
use Seyi\AirtimeVend\Services\NetworkService;
use Seyi\AirtimeVend\Services\TransactionService;
use Seyi\AirtimeVend\Services\VendingService;
use Seyi\AirtimeVend\Services\WalletTransaction;

class Airtime extends TransactionService
{
    public $network_provider;
    public $amount;

    
    public static function vend(NetworkProvider $network_provider, VendingPartner $vending_partner, $data)
    {
        try{
            $vending_service= new VendingService($vending_partner, $data);
            $network_service=new NetworkService($network_provider);
            $vend_result=$network_service->switch_partner($vending_service);
           
            if($vend_result['status']==true)
            {
                $user=auth()->user()->id;
                $other_response_data=(array)$vend_result['data'];
                $wallet=UserWallet::where('user_id',$user)->firstOrFail(); 
                $debit_wallet=new WalletTransaction($wallet);
                $debit_wallet->set_source('ACCT-VTU-VEND-'.strtoupper($network_provider->code_name))->wallet_debit($data['request_params']['amount'])->other_info($other_response_data);
                $debit_wallet->set_source('ACCT-VTU-COMM')->commission($network_provider->commission, $data['request_params']['amount']);

                return [
                    'status'=>true,
                    'message'=>'Airtime Purchase successful',
                    'data'=>$vend_result
                ];
            }
            else
            {
                throw new Exception($vend_result['message']." : ".$vend_result['error']);
            } 
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Wallet',
                'error'=>$e->getMessage()
            ]);
        }
        catch(Exception $e)
        {
            return [
                'status'=>false,
                'message'=>'Error Purchasing Airtime',
                'error'=>$e->getMessage()
            ];
        }
        
    }
}