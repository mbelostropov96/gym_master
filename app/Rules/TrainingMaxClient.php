<?php

namespace App\Rules;

use App\Enums\TrainingType;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class TrainingMaxClient implements ValidationRule, DataAwareRule
{
    private array $data;

    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = $this->data;
        $value = (int)$value;

        if ($data['type'] === TrainingType::SINGLE->value) {
            if ($value !== 1) {
                $fail(__('gym.validation.message.training_max_client'));
            }
        } else {
            if (!filter_var($value, FILTER_VALIDATE_INT, [
                'options' => [
                    'min_range' => 1,
                    'max_range' => 10,
                ],
            ])) {
                $fail(__('gym.validation.message.training_max_client'));
            }
        }
    }

    /**
     * @param array $data
     * @return TrainingMaxClient|$this
     */
    public function setData(array $data): TrainingMaxClient|static
    {
        $this->data = $data;

        return $this;
    }
}
