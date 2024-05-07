<?php

namespace App\View\Components\Admin\Tariff;

use App\View\ComponentTraits\HasTableTrait;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Tariffs extends Component
{
    use HasTableTrait;

    public function __construct(
        public readonly Collection $tariffs,
    ) {
        $this->prepareTableData(
            'admin.tariffs.update',
            [
                'id' => 'ID',
                'name' => __('gym.tariff_name'),
                'discount' => __('gym.tariff_discount'),
                'number_of_trainings' => __('gym.min_tariff_number_of_trainings'),
            ]
        );
    }

    public function render(): View|Closure|string
    {
        return view('components.admin.tariff.index');
    }
}
