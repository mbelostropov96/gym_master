<?php

namespace App\View\ValueObject;

class ButtonTableAction
{
    public function __construct(
        public readonly string $label,
        public readonly string $route,
        public readonly array $routeParams = [],
        public readonly string $method = 'GET',
        public readonly string $buttonType = 'primary',
        public readonly array $bodyParams = [],
    ) {
    }
}
