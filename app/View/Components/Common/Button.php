<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{

    public function __construct(
        public readonly string $ref = '',
        public readonly string $label = '',
        public readonly bool $post = false,
        public readonly array $postParams = [],
    ) {}


    public function render(): View|Closure|string
    {
        return view('components.common.button');
    }
}
