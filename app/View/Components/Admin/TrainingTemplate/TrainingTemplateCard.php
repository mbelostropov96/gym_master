<?php

namespace App\View\Components\Admin\TrainingTemplate;

use App\Models\TrainingTemplate;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TrainingTemplateCard extends Component
{

    public function __construct(
        public readonly TrainingTemplate $trainingTemplate,
    ) {}


    public function render(): View|Closure|string
    {
        return view('components.admin.training-template.training-template-card');
    }
}
