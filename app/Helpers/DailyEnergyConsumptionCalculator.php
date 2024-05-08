<?php

namespace App\Helpers;

use App\Enums\Gender;

class DailyEnergyConsumptionCalculator
{
    public static function calculate(string $gender, float $weight, float $height, float $age): float
    {
        return match ($gender) {
            Gender::MALE->value => 88.36 + (13.4 * $weight) + (4.8 * $height) - (5.7 * $age),
            Gender::FEMALE->value => 447.6 + (9.2 * $weight) + (3.1 * $height) - (4.3 * $age),
        };
    }
}
