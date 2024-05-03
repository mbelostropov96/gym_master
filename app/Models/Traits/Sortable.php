<?php

namespace App\Models\Traits;

use App\Http\Builder\BuilderInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method sorter(BuilderInterface $filter)
 */
trait Sortable
{
    public function scopeSorter(Builder $builder, BuilderInterface $filter): Builder
    {
        $filter->apply($builder);

        return $builder;
    }
}
