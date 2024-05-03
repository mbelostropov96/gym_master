<?php

namespace App\Models\Traits;

use App\Http\Builder\BuilderInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method filter(BuilderInterface $filter)
 */
trait Filterable
{
    public function scopeFilter(Builder $builder, BuilderInterface $filter): Builder
    {
        $filter->apply($builder);

        return $builder;
    }
}
