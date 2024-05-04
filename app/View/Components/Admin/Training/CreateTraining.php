<?php

namespace App\View\Components\Admin\Training;

use App\View\ComponentTraits\HasTableTrait;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class CreateTraining extends Component
{
    use HasTableTrait;


    public function __construct(
        public Collection $trainingTemplates
    ) {
        $this->attributeNameMap = [
            'id' => 'ID',
            'name' => __('gym.training_template_name'),
            'type' => __('gym.training_template_type'),
            'price' => __('gym.training_template_price'),
            'duration' => __('gym.training_template_duration'),
        ];
        $this->clickableRouteWithId = 'admin.create-by-template.create';
        $this->columnsName = $this->attributeNameMap;
        $this->columns = array_flip($this->attributeNameMap);
    }


    public function render(): View|Closure|string
    {
        return view('components.admin.trainings.create-training');
    }
}
