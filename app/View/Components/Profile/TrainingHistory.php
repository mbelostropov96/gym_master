<?php

namespace App\View\Components\Profile;

use App\Enums\UserRole;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TrainingHistory extends Component
{
    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.profile.training-history');
    }

    public function shouldRender(): bool
    {
        return auth()->user()->role === UserRole::CLIENT->value;
    }
}
