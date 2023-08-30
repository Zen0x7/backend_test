<?php

namespace App\Traits\Authentication\Service;

use Lcobucci\JWT\Token;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;

trait ValidatesToken
{
    public static function validates(Token|null $token): bool
    {
        $cfg = static::getConfiguration();
        $rules = [
            new SignedWith($cfg->signer(), $cfg->signingKey()),
            new IssuedBy(env('APP_URL', 'http://127.0.0.1:8000')),
        ];
        try {
            foreach ($rules as $rule) {
                $cfg->validator()->assert($token, $rule);
            }
            return !$token->isExpired(now()->toDateTimeImmutable());
        } catch (RequiredConstraintsViolated $exception) {
            return false;
        }
    }
}
