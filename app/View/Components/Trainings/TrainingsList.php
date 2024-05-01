<?php

namespace App\View\Components\Trainings;

use App\Enums\UserRole;
use App\View\ComponentTraits\HasTableTrait;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class TrainingsList extends Component
{
    use HasTableTrait;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public readonly Collection $trainings,
        public readonly Collection $instructors,
    ) {
        $this->attributeNameMap = [
            'name' => __('gym.training_name'),
            'type' => __('gym.training_type'),
            'price' => __('gym.training_price'),
            'datetime_start' => __('gym.training_start'),
            'datetime_end' => __('gym.training_end'),
            'instructor_name' =>  __('gym.instructor_name'),
        ];
        // @TODO new ручка
        $this->clickableRouteWithId = 'admin.trainings.update';
        $this->columnsName = $this->attributeNameMap;
        $this->columns = array_flip($this->attributeNameMap);

        $keyedInstructors = $this->instructors->keyBy('id');
        foreach ($this->trainings as $training) {
            $training->instructor_name = $keyedInstructors[$training->instructor_id]?->getFullName()
                ?? $training->instructor_id;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.trainings.index');
    }

    public function shouldRender() : bool
    {
        return Auth::user()->role === UserRole::CLIENT->value;
    }
}
