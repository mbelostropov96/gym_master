<?php

namespace App\View\Components\Admin;

use App\Enums\UserRole;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectRole extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $currentRole
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.select-role');
    }
}
