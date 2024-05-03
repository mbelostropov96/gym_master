<?php

namespace App\Http\Builder;

use Illuminate\Database\Eloquent\Builder;

// TODO подумать над названием
interface BuilderInterface
{
    public function apply(Builder $builder): void;
}
