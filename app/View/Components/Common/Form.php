<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public readonly string $method,
        public readonly string $action,
        public readonly string $buttonLabel,
        public readonly bool $noAction = false,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.common.form');
    }
}
