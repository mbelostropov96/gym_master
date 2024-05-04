<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{

    public function __construct(
        public iterable $columnsName,
        public iterable $columns,
        public iterable $contents,
        public string $clickableRouteWithId = '',
        public array $actions = [],
    ) {}


    public function render(): View|Closure|string
    {
        return view('components.common.table');
    }

    /**
     * @return bool
     */
    public function hasClickableRouteWithId(): bool
    {
        return !empty($this->clickableRouteWithId);
    }
}
