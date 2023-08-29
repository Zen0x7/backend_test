<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\UserDeleteRequest;
use App\Models\User;
use Illuminate\Http\Request;

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
