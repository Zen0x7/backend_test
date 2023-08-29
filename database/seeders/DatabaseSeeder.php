<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $administrator = \App\Models\User::factory()->create([
             'first_name' => 'Administrator',
             'last_name' => '',
             'email' => 'admin@buckhill.co.uk',
             'email_verified_at' => now(),
             'password' => Hash::make('admin'),
             'is_admin' => true,
             'address' => 'Ash Lane, Rustington, Littlehampton, West Sussex, BN16 3BZ',
             'phone_number' => '+44(0)208 1919 438',
         ]);

        $users = \App\Models\User::factory(3)->create([
            "is_admin" => false
        ]);
    }
}
