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
            'image' => [
                'image',
                'mimes:jpg,png,jpeg',
                'max:2048',
                'dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'
            ],
        ];
    }
}
