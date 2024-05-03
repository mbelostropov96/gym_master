<?php

namespace App\Http\Builder\Filters;

use Illuminate\Database\Eloquent\Builder;

class TrainingFilter extends AbstractFilter
{
    public const MORE_DATETIME_START = 'more_datetime_start';

    protected function getCallbacks(): array
    {
        return [
            self::MORE_DATETIME_START => [$this, 'moreDatetimeStart'],
        ];
    }

    public function moreDatetimeStart(Builder $builder, string $value): void
    {
        $builder->where('datetime_start', '>', $value);
    }
}
