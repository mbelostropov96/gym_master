<?php

namespace App\Http\Builder;

use Illuminate\Database\Eloquent\Builder;

// TODO не думать над названием
interface BuilderInterface
{
    public function apply(Builder $builder): void;
}
