<?php

namespace App\View\Components\Trainings;

use App\Models\Training;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TrainingCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public readonly Training $training,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.trainings.training-card');
    }
}
