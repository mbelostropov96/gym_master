<?php

namespace App\View\Components\Admin\Training;

use App\View\ComponentTraits\HasTableTrait;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Trainings extends Component
{
    use HasTableTrait;


    public function __construct(
        public readonly Collection $trainings,
        public readonly Collection $instructors,
    ) {
        $this->attributeNameMap = [
            'id' => 'ID',
            'name' => __('gym.training_name'),
            'type' => __('gym.training_type'),
            'price' => __('gym.training_price'),
            'datetime_start' => __('gym.training_start'),
            'datetime_end' => __('gym.training_end'),
            'instructor_name' =>  __('gym.instructor_name'),
        ];
        $this->clickableRouteWithId = 'admin.trainings.update';
        $this->columnsName = $this->attributeNameMap;
        $this->columns = array_flip($this->attributeNameMap);

        $keyedInstructors = $this->instructors->keyBy('id');
        foreach ($this->trainings as $training) {
            $training->instructor_name = $keyedInstructors[$training->instructor_id]?->getFullName()
                ?? $training->instructor_id;
        }
    }


    public function render(): View|Closure|string
    {
        return view('components.admin.trainings.index');
    }
}
