<?php

namespace App\Service;

use App\Http\Builder\Filters\TrainingFilter;
use App\Http\Builder\Sorters\TrainingSorter;
use App\Models\Training;
use Illuminate\Database\Eloquent\Collection;

class TrainingService
{
    /**
     * @param int $id
     * @param TrainingFilter|null $trainingFilter
     * @param array|null $relations
     * @return Training
     */
    public function show(int $id, array $relations = null, TrainingFilter $trainingFilter = null): Training
    {
        $builder = (new Training())->newQuery();

        if ($relations !== null) $builder->with($relations);
        if ($trainingFilter !== null) $builder->filter($trainingFilter);

        /** @var Training $training */
        $training = $builder->findOrFail($id);

        return $training;
    }

    /**
     * @param TrainingFilter|null $trainingFilter
     * @param TrainingSorter|null $trainingSorter
     * @param array|null $relations
     * @return Collection
     */
    public function index(array $relations = null, TrainingFilter $trainingFilter = null, TrainingSorter $trainingSorter = null): Collection
    {
        $builder = (new Training())->newQuery();

        if ($relations !== null) $builder->with($relations);
        if ($trainingFilter !== null) $builder->filter($trainingFilter);
        if ($trainingSorter !== null) $builder->sorter($trainingSorter);

        return $builder->get();
    }
}
