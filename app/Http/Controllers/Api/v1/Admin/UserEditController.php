<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\UserEditRequest;
use App\Models\User;

class UserEditController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UserEditRequest $request, User $user)
    {
        $fields = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
            'is_marketing' => $request->has('marketing') ? $request->input('marketing') : 0,
        ];

        if ($request->has('avatar')) {
            $fields['avatar'] = $request->input('avatar');
        }

        $user->update($fields);

        return response()
            ->json([
                'success' => true,
                'data' => [
                    'uuid' => $user->uuid,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                    'avatar' => $user->avatar,
                    'address' => $user->address,
                    'phone_number' => $user->phone_number,
                    'is_marketing' => (int) $user->is_marketing,
                    'updated_at' => $user->updated_at,
                    'created_at' => $user->created_at,
                    'last_login_at' => $user->last_login_at,
                ],
                'error' => null,
                'errors' => [],
                'extra' => [],
            ]);
    }
}
