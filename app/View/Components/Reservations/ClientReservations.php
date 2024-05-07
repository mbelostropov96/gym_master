<?php

namespace App\View\Components\Reservations;

use App\Models\Training;
use App\Services\ClientTrainings\AbstractClientTraining;
use App\View\ComponentTraits\HasTableTrait;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ClientReservations extends Component
{
    use HasTableTrait;


    public function __construct(
        public readonly Collection $reservedTrainings,
        public readonly string $trainingType = AbstractClientTraining::RESERVED,
    ) {
         $this->prepareTableData(
             'trainings.show',
             [
                 'id' => __('gym.training_id'),
                 'datetime_start' => __('gym.training_start'),
                 'datetime_end' => __('gym.training_end'),
                 'name' => __('gym.training_name'),
                 'type' => __('gym.training_type'),
                 'price' => __('gym.training_price'),
                 'instructor_name' =>  __('gym.instructor_name'),
                 'energy_consumption' => __('gym.calories_consumption'),
             ]
         );

        /** @var Training $training */
        foreach ($this->reservedTrainings as $training) {
            $training->instructor_name = $training->instructor?->getFullName()
               ?? $training->instructor_id;
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.reservations.index');
    }
}
