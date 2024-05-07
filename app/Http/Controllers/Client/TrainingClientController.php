<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRatingRequest;
use App\Models\Rating;
use App\Models\Training;
use App\Models\User;
use App\Services\ClientTrainings\AbstractClientTraining;
use App\Services\ClientTrainings\ClientTrainingFactory;
use App\Services\TrainingService;
use App\View\Components\Reservations\ClientReservations;
use App\View\Components\Trainings\ClientTrainings;
use App\View\Components\Trainings\TrainingCard;
use DateTime;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class TrainingClientController extends Controller
{
    public function __construct(
        private readonly TrainingService $trainingService,
    ) {
        parent::__construct();
    }

    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $trainings = (new ClientTrainingFactory())->create(AbstractClientTraining::AVAILABLE)->index();

        $trainings = $trainings->filter(static function (Training $training) {
            if (
                $training->max_clients <= $training->clients->count()
                || $training->clients->contains('id', '=', auth()->user()->id)
            ) {
                return false;
            }

            return true;
        });

        $trainingsListComponent = new ClientTrainings($trainings);

        return $trainingsListComponent->render()->with($trainingsListComponent->data());
    }

    /**
     * @return Renderable
     * @throws Exception
     */
    public function history(): Renderable
    {
        $trainings = (new ClientTrainingFactory())->create(AbstractClientTraining::HISTORY)->index();

        $trainingsListComponent = new ClientReservations($trainings, AbstractClientTraining::HISTORY);

        return $trainingsListComponent->render()->with($trainingsListComponent->data());
    }

    /**
     * @param int $id
     * @return Renderable
     */
    public function show(int $id): Renderable
    {
        $training = $this->trainingService->show($id, [
            'instructor',
            'clients',
            'reservations',
            'ratings',
        ]);

        $trainingComponent = new TrainingCard(
            $training,
        );

        return $trainingComponent->render()->with($trainingComponent->data());
    }

    /**
     * @param StoreRatingRequest $request
     * @return RedirectResponse
     */
    public function saveRating(StoreRatingRequest $request): RedirectResponse
    {
        $data = $request->validated();

        /** @var User $user */
        $user = auth()->user();
        $trainingId = $data['training_id'];

        $training = $this->trainingService->show($trainingId, [
            'clients',
        ]);

        if (
            $training->datetime_end > new DateTime()
            || $training->clients->doesntContain('id', '=', $user->id)
        ) {
            throw new RuntimeException('sosi', Response::HTTP_FORBIDDEN);
        }

        (new Rating())->newQuery()
            ->updateOrCreate(
                [
                    'client_id' => $user->id,
                    'training_id' => $trainingId,
                ],
                [
                    'instructor_id' => $training->instructor_id,
                    'rating' => $data['rating'],
                ]
            );

        return redirect()->to(route('trainings.show', ['id' => $training->id]));
    }
}
