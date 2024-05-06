<?php

namespace App\Http\Requests;

use App\Enums\RatingValue;
use App\Models\Training;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreRatingRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'training_id' => [
                'required',
                Rule::exists(Training::TABLE, 'id')
            ],
            'rating' => [
                'required',
                new Enum(RatingValue::class),
            ],
        ];
    }
}
