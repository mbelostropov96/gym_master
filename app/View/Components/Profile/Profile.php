<?php

namespace App\View\Components\Profile;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Profile extends Component
{
    public function __construct(
        public readonly Collection $tariffs,
        public readonly Collection $historyTrainings,
    ) {
    }

    public function render(): View|Closure|string
    {
        return view('components.profile.index');
    }
}
