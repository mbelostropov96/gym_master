<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class JustifyContainer extends Component
{
    public function __construct()
    {
        //
    }


    public function render(): View|Closure|string
    {
        return view('components.common.justify-container');
    }
}
