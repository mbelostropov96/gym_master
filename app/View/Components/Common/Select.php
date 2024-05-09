<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public function __construct(
        public readonly array $values = [],
        public readonly mixed $currentValue = '',
        public readonly string $label = '',
        public readonly string $name = '',
        public readonly bool $isDisabled = false,
        public readonly bool $useValueId = false,
        public readonly bool $needSend = true,
    ) {
        //
    }


    public function render(): View|Closure|string
    {
        return view('components.common.select');
    }
}
