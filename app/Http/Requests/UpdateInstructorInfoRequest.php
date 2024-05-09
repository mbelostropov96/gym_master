<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class UpdateInstructorInfoRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'experience' => ['string', 'max:255'],
            'qualification' => ['string', 'max:255'],
            'description' => ['string', 'max:255'],
        ];
    }
}
