<?php

namespace App\Http\Requests;

use App\Helpers\UserHelper;
use App\Models\User;
use DateInterval;
use DateTime;
use Exception;
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
            'energy_consumption' => ['string'],
            'instructor_id' => [
                Rule::prohibitedIf(!UserHelper::isAdmin()),
                'string',
                Rule::exists(User::TABLE, 'id')
            ],
        ];
    }

    /**
     * @throws Exception
     */
    protected function prepareForValidation(): void
    {
        if (!isset($this->datetime_end)) {
            $duration = $this->duration;
            $datetimeStart = DateTime::createFromFormat('Y-m-d\TH:i', $this->datetime_start);
            $a = $datetimeStart->add(new DateInterval('PT' . $duration . 'H'));
            $this->merge([
                'datetime_end' => $a->format('Y-m-d\TH:i'),
            ]);
        }
    }
}
