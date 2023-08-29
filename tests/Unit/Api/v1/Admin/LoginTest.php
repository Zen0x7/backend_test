<?php

namespace Tests\Unit\Api\v1\Admin;

use App\Models\User;
use App\Services\Authentication;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_authentication_success(): void
    {
        $admin = User::query()
            ->where('email', 'admin@buckhill.co.uk')
            ->first();

        $response = $this->json("POST", route('api::v1::admin::login'), [
            "email" => $admin->email,
            "password" => "admin"
        ]);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            "success",
            "data" => [
                "token"
            ],
            "error",
            "errors" => [],
            "extra" => [],
        ]);

        $token = Authentication::decode(json_decode($response->content())->data->token);

        $this->assertTrue(Authentication::validates($token));
        $this->assertTrue(Authentication::belongsTo($token, $admin));
    }
}
