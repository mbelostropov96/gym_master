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
            'date' => ['required', 'date_format:Y-m-d H:i:s'],
            'duration' => ['required', 'string', 'between:1,300'],
            'instructor_id' => [
                'required',
                'string',
                Rule::exists(User::TABLE, 'id')
            ],
        ];
    }
}
