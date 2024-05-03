<?php

namespace App\Http\Builder\Filters;

use Illuminate\Database\Eloquent\Builder;

class TrainingFilter extends AbstractFilter
{
    public const MORE_DATETIME_START = 'more_datetime_start';
    public const CLIENT_ID = 'client_id';

    protected function getCallbacks(): array
    {
        return [
            self::MORE_DATETIME_START => [$this, 'moreDatetimeStart'],
            self::CLIENT_ID => [$this, 'clientId'],
        ];
    }

    public function moreDatetimeStart(Builder $builder, string $value): void
    {
        $builder->where('datetime_start', '>', $value);
    }

    public function clientId(Builder $builder, string $value): void
    {
        $builder->whereHas('reservations', function (Builder $builder) use ($value) {
            $builder->where('client_id', '=', $value);
        });
    }
}
