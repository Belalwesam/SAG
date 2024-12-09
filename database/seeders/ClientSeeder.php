<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = User::create([
            "name" => "client",
            "username" => "client",
            "email" => "client@sag.com",
            "password" => bcrypt('client'),
            "hours" => 20,
            "image" => "public/clients/client.png"
        ]);
    }
}
