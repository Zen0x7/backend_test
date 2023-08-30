<?php

namespace App\Http\Requests\Api\v1\Admin;

use Illuminate\Validation\Rule;

class UserListingRequest extends AdministratorRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'sortBy' => ['sometimes', Rule::in(['first_name', 'last_name', 'email', 'address', 'created_at', 'updated_at'])],
            'desc' => ['sometimes', Rule::in(['first_name', 'last_name', 'email', 'address', 'created_at', 'updated_at'])],
            'marketing' => 'sometimes|boolean',
        ];
    }
}
