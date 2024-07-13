<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Khaled',
            'last_name' => 'Atef',
            'email' => 'khaledatef312@gmail.com',
            'password' => bcrypt('123456789'),
            'image' => 'default.png'
        ]);
    }
}
