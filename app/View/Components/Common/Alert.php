<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{

    public function __construct(
        public readonly string $type,
        public readonly string $message,
    ) {}


    public function render(): View|Closure|string
    {
        return view('components.common.alert');
    }
}
