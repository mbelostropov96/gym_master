<?php

namespace App\Http\Builder\Filters;

use App\Http\Builder\BuilderInterface;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractFilter implements BuilderInterface
{
    private array $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    abstract protected function getCallbacks(): array;

    public function apply(Builder $builder): void
    {
        foreach ($this->getCallbacks() as $field => $value) {
            if (array_key_exists($field, $this->params)) {
                call_user_func($value, $builder, $this->params[$field]);
            }
        }
    }
}
