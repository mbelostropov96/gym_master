<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use App\Services\ClientTrainings\AbstractClientTraining;
use App\Services\ClientTrainings\ClientTrainingFactory;
use App\View\Components\Profile\Profile;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function profile(): Renderable
    {
        // кринге чел, почини \App\Http\Controllers\UserController::profile и перестань получать данные с шаблонов
        $tariffs = (new Tariff())->newQuery()
            ->orderBy('discount')
            ->get();

        $trainings = (new ClientTrainingFactory())->create(AbstractClientTraining::HISTORY)->index();

        $profileComponent = new Profile($tariffs, $trainings);

        return $profileComponent->render()->with($profileComponent->data());
    }
}
