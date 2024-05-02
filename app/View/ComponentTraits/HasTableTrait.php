<?php

namespace App\View\ComponentTraits;

trait HasTableTrait
{
    public string $clickableRouteWithId;
    public array $columnsName;
    public array $columns;

    private array $attributeNameMap;
}
