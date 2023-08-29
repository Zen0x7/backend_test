<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\LoginRequest;
use App\Models\User;
use App\Services\Authentication;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        $user = User::query()->where(['email' => $request->input('email'), 'is_admin' => true])
            ->first();

        if ($user && Hash::check($request->input('password'), $user->password)) {
            $token = Authentication::issue($user);

            $user->update([
                'last_login_at' => now(),
            ]);

            return response()->json([
                'success' => 1,
                'data' => ['token' => $token],
                'error' => null,
                'errors' => [],
                'extra' => [],
            ]);
        }
        return response()->json([
            'success' => 0,
            'data' => [],
            'error' => __('Failed to authenticate user'),
            'errors' => [],
            'trace' => [],
        ]);
    }
}
