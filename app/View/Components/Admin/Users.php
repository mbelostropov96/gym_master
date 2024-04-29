<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Users extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $attributeNameMap,
        public Collection $users,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view(
            'components.admin.users.index',
            [
                'columnsName' => $this->attributeNameMap,
                'users' => $this->users,
                'columns' => array_flip($this->attributeNameMap),
                'clickableRouteWithId' => 'users.update',
            ]
        );
    }
}
