<?php

namespace App\Http\Requests;

use App\Enums\TrainingType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\Enum;

class UpdateTrainingTemplateRequest extends AbstractRequest
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
            'type' => [
                new Enum(TrainingType::class),
            ],
            'price' => [],
            'duration' => ['string'],
        ];
    }
}
