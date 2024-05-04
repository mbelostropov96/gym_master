<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class UpdateTrainingRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'description' => ['string'],
            'datetime_start' => ['date_format:Y-m-d\TH:i'],
            'datetime_end' => ['date_format:Y-m-d\TH:i'],
            'instructor_id' => [
                'string',
                Rule::exists(User::TABLE, 'id')
            ],
        ];
    }
}
