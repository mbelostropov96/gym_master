<?php

namespace App\Http\Requests;

use App\Rules\AvailableTariff;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateClientInfoRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'age' => ['string'],
            'gender' => ['string'],
            'weight' => ['string'],
            'height' => ['string'],
            'tariff_id' => [
                'string',
                new AvailableTariff(),
            ],
        ];
    }
}
