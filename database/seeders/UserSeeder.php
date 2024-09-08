<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name"=> "John Doe",
            "email"=> "john@mail.com",
            "password"=>Hash::make('12345678')
        ]);

        User::create([
            "name"=> "Sarah Doe",
            "email"=> "sarah@mail.com",
            "password"=>Hash::make('12345678')
        ]);

        User::create([
            "name"=> "Akin Olu",
            "email"=> "akin@mail.com",
            "password"=>Hash::make('12345678')
        ]);
    }
}
