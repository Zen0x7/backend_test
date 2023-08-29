<?php

namespace App\Traits\Authentication\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait AuthorizeAccess
{
    public function authorize(Request $request, Closure $next, User $user)
    {
        Auth::login($user);
        return $next($request);
    }
}
