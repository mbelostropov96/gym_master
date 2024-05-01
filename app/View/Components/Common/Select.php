<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public readonly array $values = [],
        public readonly mixed $currentValue = '',
        public readonly string $label = '',
        public readonly string $name = '',
        public readonly bool $isDisabled = false,
        public readonly bool $useValueId = false,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.common.select');
    }
}
