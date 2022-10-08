<?php

namespace Database\Seeders;

use App\Models\User;
use App\Traits\Utilities;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    use Utilities;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'uuid' => $this->generateUuid(),
            'name' => 'Ndirangu Waweru',
            'email' => 'ndiranguwaweru@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
    }
}
