<?php

namespace App\Rules;

use App\Models\Tariff;
use App\Models\User;
use App\Services\ClientTrainings\AbstractClientTraining;
use App\Services\ClientTrainings\ClientTrainingFactory;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class AvailableTariff implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var User $user */
        $user = auth()->user();

        $trainings = (new ClientTrainingFactory())->create(AbstractClientTraining::HISTORY)->index();
        $availableTariffs = (new Tariff())->newQuery()
            ->where('id', '>', $user->clientInfo->tariff_id)
            ->where('number_of_trainings', '<=', $trainings->count())
            ->get();

        if (!in_array((int)$value, $availableTariffs->pluck('id')->toArray(), true)) {
            $fail(__('gym.validation.message.tariff_not_available'));
        }
    }
}
