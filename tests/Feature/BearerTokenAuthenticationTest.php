<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\Authentication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Tests\TestCase;

class BearerTokenAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_token_shape_is_valid(): void
    {
        $admin = $this->createAdmin();

        $regex = "/^([a-zA-Z0-9_=]+)\.([a-zA-Z0-9_=]+)\.([a-zA-Z0-9_\-\+\/=]*)/";

        $token = Authentication::issue($admin);

        $random = Str::random(36);

        $this->assertTrue(
            preg_match(
                $regex,
                $token
            ) == 1
        );

        $this->assertTrue(
            preg_match(
                $regex,
                $random
            ) == 0
        );
    }

    public function test_token_can_be_decoded(): void
    {
        $admin = $this->createAdmin();

        $token = Authentication::issue($admin);

        $configuration = Configuration::forAsymmetricSigner(
            new Sha256(),
            InMemory::file(storage_path('private_key.pem')),
            InMemory::file(storage_path('public_key.pem'))
        );

        try {
            $configuration->parser()->parse($token);
            $this->assertTrue(true);
        } catch (\Throwable $exception) {
            $this->fail();
        }
    }
}
