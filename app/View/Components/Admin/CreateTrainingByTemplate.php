<?php

namespace App\View\Components\Admin;

use App\Models\TrainingTemplate;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class CreateTrainingByTemplate extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public TrainingTemplate $trainingTemplate,
        public Collection $instructors,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.create-training-by-template');
    }
}
