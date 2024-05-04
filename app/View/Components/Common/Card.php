<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{

    public function __construct(
        public string $headerName
    ){
    }


    public function render(): View|Closure|string
    {
        return view('components.common.card');
    }
}
