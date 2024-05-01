<?php

namespace App\Http\Requests;

use App\Enums\TrainingType;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreTrainingRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['string'],
            'type' => [
                'required',
                new Enum(TrainingType::class),
            ],
            'price' => ['required', 'string'],
            'datetime_start' => ['required', 'date_format:Y-m-d\TH:i'],
            'datetime_end' => ['date_format:Y-m-d\TH:i'],
            'duration' => ['string'],
            'instructor_id' => [
                'required',
                'string',
                Rule::exists(User::TABLE, 'id')
            ],
        ];
    }
}
