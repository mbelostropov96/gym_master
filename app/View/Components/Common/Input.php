<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public function __construct(
        public string $id = '',
        public string $label = '',
        public string $name = '',
        public mixed $value = '',
        public bool $isDisabled = false,
        public bool $isRequired = true,
        public ?string $type = null,
    ) {
    }


    public function render(): View|Closure|string
    {
        return view('components.common.input');
    }
}
