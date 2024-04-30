<?php

namespace App\View\Components\Admin\TrainingTemplate;

use App\Models\TrainingTemplate;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TrainingTemplateCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public readonly TrainingTemplate $trainingTemplate,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.training-template.training-template-card');
    }
}
