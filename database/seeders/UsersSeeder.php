<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\ContactGroup;
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
        $user = User::create([
            'uuid' => $this->generateUuid(),
            'name' => 'Ndirangu Waweru',
            'email' => 'ndiranguwaweru@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        if (App::environment('local')) {
            $contactGroup = ContactGroup::create([
                'uuid' => $this->generateUuid(),
                'name' => 'Friends',
                'user_id' => $user->id,
            ]);

            $contacts = [
                [
                    'name' => 'Jane Doe',
                    'phone' => '0726133141',
                ],
                [
                    'name' => 'James Doe',
                    'phone' => '0726133142',
                ],
                [
                    'name' => 'Carl Doe',
                    'phone' => '0726133143',
                ],
                [
                    'name' => 'Michelle Doe',
                    'phone' => '0726133144',
                ],
                [
                    'name' => 'Sistine Doe',
                    'phone' => '0726133145',
                ],
            ];

            $contactsData = collect($contacts)->map(function ($contact) use ($contactGroup) {
                return [
                    'uuid' => $this->generateUuid(),
                    'name' => $contact['name'],
                    'phone' => $contact['phone'],
                    'contact_group_id' => $contactGroup->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            });

            Contact::insert($contactsData->toArray());
        }
    }
}
