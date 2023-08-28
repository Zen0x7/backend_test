<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\JwtToken;
use App\Models\User;
use App\Traits\Authentication\Service\IssueToken;
use App\Traits\Authentication\Service\ValidatesToken;
use App\Traits\Authentication\Service\VerifyAssociation;
use Illuminate\Support\Carbon;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token;

final class Authentication
{
    use IssueToken, ValidatesToken, VerifyAssociation;

    public static function createToken(
        User $user,
        string $unique_id,
        Carbon $end_of_day
    ) {
        return JwtToken::query()
            ->create([
                'user_id' => $user->id,
                'unique_id' => $unique_id,
                'token_title' => __('Token generated at :timestamp', [
                    'timestamp' => now()->format('d-m-Y H:i:s'),
                ]),
                'expires_at' => $end_of_day,
            ]);
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

    public static function getUser(Token $token): null|User
    {
        $user_uuid = $token->claims()->get('user_uuid');

        return User::query()->where('uuid', $user_uuid)->first() ?? null;
    }

    private static function getConfiguration(): Configuration
    {
        return Configuration::forAsymmetricSigner(
            new Sha256(),
            InMemory::file(storage_path('private_key.pem')),
            InMemory::file(storage_path('public_key.pem'))
        );
    }
}
