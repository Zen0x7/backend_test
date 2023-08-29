<?php

namespace App\Traits\Authentication\Service;

use App\Models\User;
use Illuminate\Support\Str;

trait IssueToken
{
    public static function issue(User $user): string
    {
        $configuration = static::getConfiguration();

        $now = now();
        $unique_id = Str::uuid()->toString();
        $expires_at = $now->copy()->endOfDay();

        static::createToken($user, $unique_id);

        $token = $configuration->builder()
            ->issuedBy(env('APP_URL', 'http://127.0.0.1:8000'))
            ->identifiedBy($user->email)
            ->issuedAt($now->toDateTimeImmutable())
            ->expiresAt($expires_at->toDateTimeImmutable())
            ->withClaim('user_uuid', $user->uuid)
            ->withClaim('unique_id', $unique_id)
            ->getToken($configuration->signer(), $configuration->signingKey());

        return $token->toString();
    }
}
