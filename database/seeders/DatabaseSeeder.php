<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(RolesPermissionsSeeder::class);

        $user = User::create([
            'first_name' => 'Khaled',
            'last_name' => 'Atef',
            'email' => 'khaledatef312@gmail.com',
            'password' => bcrypt('Kh159753At@'),
        ]);

        $user->syncRoles(['owner']);
    }
}
