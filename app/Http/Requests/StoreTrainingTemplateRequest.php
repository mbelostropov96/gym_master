<?php

namespace App\Http\Requests;

use App\Enums\TrainingType;
use App\Rules\TrainingMaxClient;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\Enum;

class StoreTrainingTemplateRequest extends AbstractRequest
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
            'price' => ['required'],
            'energy_consumption' => ['required', 'string'],
            'max_clients' => [
                'required',
                'string',
                new TrainingMaxClient(),
            ],
            'duration' => ['required', 'string'],
        ];
    }
}
