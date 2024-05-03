<?php

namespace App\Service;

use App\Http\Builder\Filters\TrainingFilter;
use App\Http\Builder\Sorters\TrainingSorter;
use App\Models\Training;
use Illuminate\Database\Eloquent\Collection;

class TrainingService
{
    public function index(TrainingFilter $trainingFilter = null, TrainingSorter $trainingSorter = null, array $relations = null): Collection
    {
        $builder = (new Training())->newQuery();

        if ($trainingFilter !== null) $builder->filter($trainingFilter);
        if ($trainingSorter !== null) $builder->sorter($trainingSorter);
        if ($relations !== null) $builder->with($relations);

        return $builder->get();
    }
}
