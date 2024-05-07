<?php

namespace App\View\Components\Tariff;

use App\View\ComponentTraits\HasTableTrait;
use App\View\ValueObject\ButtonTableAction;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Tariffs extends Component
{
    use HasTableTrait;

    public function __construct(
        public readonly Collection $tariffs,
        public readonly int $currentTrainingsCount,
    ) {
        $this->prepareTableData(
            '',
            [
                'name' => __('gym.tariff_name'),
                'discount' => __('gym.tariff_discount'),
                'number_of_trainings' => __('gym.min_tariff_number_of_trainings'),
            ]
        );
        $this->actions = [
            new ButtonTableAction(
                __('gym.change_tariff'),
                'users.client-info.update',
                [],
                'PATCH',
                'success',
                [
                    'tariff_id' => 'id',
                ],
                ['number_of_trainings' => $this->currentTrainingsCount],
            ),
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tariff.tariffs');
    }
}
