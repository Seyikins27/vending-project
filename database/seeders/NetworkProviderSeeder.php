<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Seyi\AirtimeVend\Models\NetworkProvider;

class NetworkProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NetworkProvider::create([
            'name'=>'MTN',
            'code_name'=>'mtn',
            'commission'=>5
        ]);

        NetworkProvider::create([
            'name'=>'GLO',
            'code_name'=>'glo',
            'commission'=>10
        ]);
    }
}
