<?php

namespace App\Http\Builder\Sorters;

use App\Http\Builder\BuilderInterface;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractSorter implements BuilderInterface
{
    public const SORT_ASC = 'asc';
    public const SORT_DESC = 'desc';

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
