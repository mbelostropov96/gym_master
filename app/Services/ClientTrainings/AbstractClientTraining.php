<?php

namespace App\Services\ClientTrainings;

use Illuminate\Database\Eloquent\Collection;

abstract class AbstractClientTraining
{
    public const AVAILABLE = 'available';
    public const RESERVED = 'reserved';
    public const HISTORY = 'history';

    abstract public function index(): Collection;
}
