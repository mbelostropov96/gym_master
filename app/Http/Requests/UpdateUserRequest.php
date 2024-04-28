<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['string', 'max:255'],
            'middle_name' => ['string', 'max:255'],
            'last_name' => ['string', 'max:255'],
            'email' => ['email:rfc,dns'],
            'password' => ['string', Password::min(8)],
            'role' => [
                Rule::excludeIf(auth()->user()->role !== UserRole::ADMIN->value),
                new Enum(UserRole::class),
            ],
        ];
    }

    /**
     * @return array
     */
    public function validatedWithCasts(): array
    {
        $result = $this->validated();

        if (isset($result['password'])) {
            $result['password'] = Hash::make($result['password']);
        }

        return $result;
    }
}
