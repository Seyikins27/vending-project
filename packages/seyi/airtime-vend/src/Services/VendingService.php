<?php

namespace Seyi\AirtimeVend\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Seyi\AirtimeVend\Models\VendingPartner;

class VendingService
{
    use Error;
    private $endpoint, $header_information, $parameters;
    function __construct(VendingPartner $vending_partner, $data)
    {
        $this->endpoint=$vending_partner->endpoint;
        //$vending_data=['amount'=>$data['amount'],'phone'=>$data['phone']];
        $parameters=[];
        $header_params=[];
        foreach($vending_partner->parameters as $param)
        {
            $parameters[$param]=$data['request_params'][$param];
        }

        foreach($vending_partner->header_information as $header)
        {
            $header_params[$header]=$data['header_params'][$header];
        }
        $this->parameters=$parameters;
        $this->header_information=$header_params;
    }
    public function request()
    {
        try{
            $request=Http::acceptJson()->withHeaders($this->header_information)->post($this->endpoint, $this->parameters);
            $request_body=json_decode($request->getBody()->getContents());
            
            if($request_body !=null && in_array($request_body->status,['success',200])===true)
            {
                return [
                    'status'=>true,
                    'message'=>'Vending Successful',
                    'data'=>$request_body
                ];
            }
            else{
                throw new Exception('Vending Error : Could not connect to vending service');
            }
           
        }
        catch(Exception $e)
        {
           return [
            'status'=>false,
            'message'=>'Error making request to vending service ',
            'error'=>$e->getMessage()
           ];
        }
       
    }

    public function get_request($data)
    {
        $request=Http::acceptJson()->withHeaders($data->endpoint, $data->parameters);
        return $request;
    }

}