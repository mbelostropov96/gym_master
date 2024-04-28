<?php

namespace App\Service\DTO;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

class AbstractDTO implements Arrayable
{
    public function toArray(): array
    {
        $result = [];
        foreach (get_object_vars($this) as $key => $value) {
            $result[Str::snake($key)] = $value;
        }

        return $result;
    }

    public function __get(string $name): ?string
    {
        $property = Str::camel($name);

        return $this->{$property} ?? null;
    }
}
