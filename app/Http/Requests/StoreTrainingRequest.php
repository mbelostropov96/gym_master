<?php

namespace App\Http\Requests;

use App\Enums\TrainingType;
use App\Helpers\UserHelper;
use App\Models\User;
use App\Rules\TrainingMaxClient;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Query\Builder;
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
            'energy_consumption' => ['required', 'string'],
            'max_clients' => [
                'required',
                'string',
                new TrainingMaxClient(),
            ],
            'datetime_start' => ['required', 'date_format:Y-m-d\TH:i'],
            'datetime_end' => ['required', 'date_format:Y-m-d\TH:i'],
            'instructor_id' => [
                'required',
                'string',
                Rule::exists(User::TABLE, 'id')->where(function (Builder $query) {
                    if (!UserHelper::isAdmin()) {
                        $query->where('id', '=', auth()->id());
                    }

                    return $query;
                }),
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
