<?php

namespace App\View\Components\Admin\TrainingTemplate;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CreateTrainingTemplate extends Component
{
    public function __construct()
    {
        //
    }


    public function render(): View|Closure|string
    {
        return view('components.admin.training-templates.create-training-template');
    }
}
