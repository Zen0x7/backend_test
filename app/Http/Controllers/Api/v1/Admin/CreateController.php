<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\CreateRequest;
use App\Models\User;
use App\Services\Authentication;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateRequest $request)
    {
        $user = User::query()->create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'avatar' => $request->input('avatar'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
            'is_marketing' => $request->has('marketing') ? $request->input('marketing') : 0,
            'is_admin' => true,
        ]);

        $token = Authentication::issue($user);

        return response()
            ->json([
                'success' => true,
                'data' => [
                    'uuid' => $user->uuid,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number,
                    'updated_at' => $user->updated_at,
                    'created_at' => $user->created_at,
                    'token' => $token,
                ],
                'error' => null,
                'errors' => [],
                'extra' => [],
            ]);
    }
}
