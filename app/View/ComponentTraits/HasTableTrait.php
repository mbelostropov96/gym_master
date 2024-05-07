<?php

namespace App\View\ComponentTraits;

trait HasTableTrait
{
    public string $clickableRouteWithId;
    public array $columnsName;
    public array $columns;
    public array $actions = [];

    private function prepareTableData(string $route, array $attributeNameMap): void
    {
        $this->clickableRouteWithId = $route;
        $this->columnsName = $attributeNameMap;
        $this->columns = array_flip($attributeNameMap);
    }
}
