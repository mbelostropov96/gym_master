<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{
    public function __construct(
        public readonly string $method,
        public readonly string $action,
        public readonly string $buttonLabel,
        public readonly bool $noAction = false,
    ) {
    }


    public function render(): View|Closure|string
    {
        return view('components.common.form');
    }
}
