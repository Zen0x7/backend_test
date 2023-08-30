<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createAdmin()
    {
        $query = User::query()->where('email', 'admin@buckhill.co.uk');
        return $query->exists() ?
            $query->first() :
            User::factory()->create([
                'uuid' => Str::uuid()->toString(),
                'first_name' => 'Administrator',
                'last_name' => '',
                'email' => 'admin@buckhill.co.uk',
                'email_verified_at' => now(),
                'password' => Hash::make('admin'),
                'is_admin' => true,
                'address' => 'Ash Lane, Rustington, Littlehampton, West Sussex, BN16 3BZ',
                'phone_number' => '+44(0)208 1919 438',
            ]);
    }
}
