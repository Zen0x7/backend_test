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
        $rules = [
            new IdentifiedBy($for->email),
            new HasClaimWithValue('user_uuid', $for->uuid),
        ];
        try {
            foreach ($rules as $rule) {
                $configuration->validator()
                    ->assert($token, $rule);
            }
            return true;
        } catch (RequiredConstraintsViolated $exception) {
            return false;
        }
    }
}
