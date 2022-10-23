<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\ContactGroup;
use App\Models\Payment;
use App\Models\User;
use App\Traits\Utilities;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
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
        $user = User::firstOrCreate(
            ['email' => 'ndiranguwaweru@gmail.com'],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'Ndirangu Waweru',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        if (App::environment('local')) {
            ContactGroup::factory()
                ->count(5)
                ->has(Contact::factory()->count(20))
                ->create([
                    'user_id' => $user->id,
                ]);

            $payments = Payment::factory()
                ->count(10)
                ->create([
                    'user_id' => $user->id,
                ]);

            $user->update([
                'credit' => $payments->sum('amount'),
                'credit_updated_at' => now(),
            ]);
        }
    }
}
