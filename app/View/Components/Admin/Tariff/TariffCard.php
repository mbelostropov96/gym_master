<?php

namespace App\View\Components\Admin\Tariff;

use App\Models\Tariff;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TariffCard extends Component
{
    public function __construct(
        public readonly Tariff $tariff,
    ) {
    }

    public function render(): View|Closure|string
    {
        return view('components.admin.tariff.tariff-card');
    }
}
