<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Seyi\AirtimeVend\Models\VendingPartner;

class VendingPartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VendingPartner::create([
            'name'=>'Shaggo',
            'endpoint'=>'http://test.shagopayments.com/public/api/test/b2b',
            'header_information'=>[
                'Content-Type',
                'email',
                'password',
                'hashKey' 
            ],
            'parameters'=>[
                "serviceCode",
                "phone",
                "amount",
                "vend_type",
                "network",
                "request_id"
            ],
            'network_attribute'=>'network'
            ]);

            VendingPartner::create([
                'name'=>'BAP',
                'endpoint'=>'https://api.staging.baxibap.com/services/airtime/request',
                'header_information'=>[
                    'Content-Type',
                    'Accept',
                    'x-api-key' 
                ],
                'parameters'=>[
                    "phone",
                    "amount",
                    "service_type",
                    "plan",
                    "agentId",
                    "agentReference"
                ],
                'network_attribute'=>'service_type'
                ]);
    }
}
