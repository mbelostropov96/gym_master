<?php

namespace App\View\Components\Reservations;

use App\View\ComponentTraits\HasTableTrait;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ReservationsList extends Component
{
    use HasTableTrait;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public readonly Collection $reservedTrainings,
    ) {
         $this->attributeNameMap = [
            'id' => 'ID',
            'name' => __('gym.'),
            'type' => __('gym.'),
            'price' => __('gym.'),
            'datetime_start' => __('gym.'),
            'datetime_end' => __('gym.'),
            'instructor_name' =>  __('gym.'),
        ];
        $this->clickableRouteWithId = 'reservations.update';
        $this->columnsName = $this->attributeNameMap;
        $this->columns = array_flip($this->attributeNameMap);
    }

    public function render(): View|Closure|string
    {
        return view('components.reservations.index');
    }
}
