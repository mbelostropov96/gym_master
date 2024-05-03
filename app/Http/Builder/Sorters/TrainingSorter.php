<?php

namespace App\Http\Builder\Sorters;

use Illuminate\Database\Eloquent\Builder;

class TrainingSorter extends AbstractSorter
{
    public const ORDER_BY_DATETIME_START = 'order_by_datetime_start';

    protected function getCallbacks(): array
    {
        return [
            self::ORDER_BY_DATETIME_START => [$this, 'orderByDatetimeStart'],
        ];
    }

    public function orderByDatetimeStart(Builder $builder, string $value): void
    {
        $builder->orderBy('datetime_start', $value);
    }
}
