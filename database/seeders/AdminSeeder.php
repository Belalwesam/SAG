<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'John Doe',
            'username' => 'admin',
            'email' => 'admin@tadbeer.com',
            'password' => 'admin'
        ]);

        Admin::create([
            'name' => 'Mohammad Omar',
            'username' => 'momar',
            'email' => 'mohammad@sag.com',
            'password' => 'admin'
        ]);
    }
}
