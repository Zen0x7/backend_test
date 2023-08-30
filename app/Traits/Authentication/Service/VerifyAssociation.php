<?php

namespace App\Traits\Authentication\Service;

use App\Models\User;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\Validation\Constraint\HasClaimWithValue;
use Lcobucci\JWT\Validation\Constraint\IdentifiedBy;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;

trait VerifyAssociation
{
    public static function belongsTo(Token $token, User $for): bool
    {
        $configuration = static::getConfiguration();
        try {
            $configuration->validator()->assert($token, new IdentifiedBy($for->email));
            $configuration->validator()->assert($token, new HasClaimWithValue('user_uuid', $for->uuid));
            return $token->claims()->has('unique_id') &&
                $for->tokens()
                    ->where('unique_id', $token->claims()->get('unique_id'))
                    ->whereNull('expires_at')
                    ->exists();
        } catch (RequiredConstraintsViolated $exception) {
            return false;
        }
    }
}
