<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StarInput extends Component
{
    public function __construct(
        public string $id = '',
        public string $label = '',
        public string $name = '',
        public mixed $value = '',
        public bool $isDisabled = false,
    ) {
    }

    public function render(): View|Closure|string
    {
        return view('components.common.star-input');
    }
}
