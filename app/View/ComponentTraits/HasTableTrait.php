<?php

namespace App\View\ComponentTraits;

trait HasTableTrait
{
    public string $clickableRouteWithId;
    public array $columnsName;
    public array $columns;
    public array $actions = [];

    private array $attributeNameMap;
}
