<?php

namespace App\Services;

use App\Models\JwtToken;
use App\Models\User;
use Illuminate\Support\Str;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Token\RegisteredClaims;
use Lcobucci\JWT\Validation\Constraint\HasClaimWithValue;
use Lcobucci\JWT\Validation\Constraint\IdentifiedBy;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;

class Authentication
{
    private static function getConfiguration(): Configuration
    {
        return Configuration::forAsymmetricSigner(
            new Sha256(),
            InMemory::file(storage_path('private_key.pem')),
            InMemory::file(storage_path('public_key.pem'))
        );
    }

    public static function issue(User $user): string
    {
        $configuration = static::getConfiguration();

        $now = now();
        $unique_id = Str::uuid()->toString();
        $end_of_day = $now->endOfDay();

        JwtToken::query()
            ->create([
                'user_id' => $user->id,
                'unique_id' => $unique_id,
                'token_title' => __("Token generated at :timestamp", [
                    "timestamp" => now()->format('d-m-Y H:i:s')
                ]),
                'expires_at' => $end_of_day,
            ]);

        $token = $configuration->builder()
            ->issuedBy(env('APP_URL', 'http://127.0.0.1:8000'))
            ->identifiedBy($user->email)
            ->issuedAt($now->toDateTimeImmutable())
            ->expiresAt($end_of_day->toDateTimeImmutable())
            ->withClaim('user_uuid', $user->uuid)
            ->withClaim('unique_id', $unique_id)
            ->getToken($configuration->signer(), $configuration->signingKey());

        return $token->toString();
    }

    public static function decode(string $token): null|Token
    {
        $configuration = static::getConfiguration();
        try {
            return $configuration->parser()->parse($token);
        } catch (\Throwable $exception) {
            return null;
        }
    }

    public static function validates(Token $token): bool
    {
        $configuration = static::getConfiguration();
        try {
            $configuration->validator()->assert($token, new SignedWith($configuration->signer(), $configuration->signingKey()));
            $configuration->validator()->assert($token, new IssuedBy(env('APP_URL', 'http://127.0.0.1:8000')));
            return true;
        } catch (RequiredConstraintsViolated $exception) {
            return false;
        }
    }

    public static function belongsTo(Token $token, User $for): bool
    {
        $configuration = static::getConfiguration();
        try {
            $configuration->validator()->assert($token, new IdentifiedBy($for->email));
            $configuration->validator()->assert($token, new HasClaimWithValue("user_uuid", $for->uuid));
            return true;
        } catch (RequiredConstraintsViolated $exception) {
            return false;
        }
    }
}
