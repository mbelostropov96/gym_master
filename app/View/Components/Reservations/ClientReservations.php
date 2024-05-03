<?php

namespace App\View\Components\Reservations;

use App\Models\Training;
use App\View\ComponentTraits\HasTableTrait;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ClientReservations extends Component
{
    use HasTableTrait;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public readonly Collection $reservedTrainings
    ) {
         $this->attributeNameMap = [
             'training_id' => __('gym.training_id'),
             'name' => __('gym.training_name'),
             'type' => __('gym.training_type'),
             'price' => __('gym.training_price'),
             'datetime_start' => __('gym.training_start'),
             'datetime_end' => __('gym.training_end'),
             'instructor_name' =>  __('gym.instructor_name'),
        ];
        $this->clickableRouteWithId = 'trainings.show';
        $this->columnsName = $this->attributeNameMap;
        $this->columns = array_flip($this->attributeNameMap);

        /** @var Training $training */
        foreach ($this->reservedTrainings as $training) {
            $training->instructor_name = $training->instructor?->getFullName()
                ?? $training->instructor_id;
            $training->id = $training->training_id;
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.reservations.index');
    }
}
