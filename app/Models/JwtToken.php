<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JwtToken extends Model
{
    use HasFactory;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'unique_id',
        'user_id',
        'token_title',
        'restrictions',
        'permissions',
        'expires_at',
        'last_used_at',
        'refreshed_at',
    ];
}
