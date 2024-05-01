<?php

namespace App\Http\Controllers\Client;

use App\Enums\TrainingType;
use App\Models\Training;
use Illuminate\Contracts\Support\Renderable;

class TrainingClientController
{
    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $trainings = (new Training())->newQuery()
            ->with([
                'clients',
                'instructor',
            ])
            ->get();

        $trainings = $trainings->filter(static function (Training $training) {
            if (
                $training->type === TrainingType::SINGLE->value
                && $training->clients->isNotEmpty()
            ) {
                return false;
            }

            return true;
        });

        return view('');
    }
}
