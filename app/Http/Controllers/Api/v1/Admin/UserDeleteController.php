<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\UserDeleteRequest;

class UserDeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UserDeleteRequest $request, User $user)
    {
        $user->tokens()->delete();
        $user->delete();
        return response()->json([
            'success' => 1,
            'data' => [],
            'error' => null,
            'errors' => [],
            'extra' => [],
        ]);
    }
}
