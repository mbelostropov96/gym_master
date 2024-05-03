<?php

namespace App\Http\Controllers\Client;

use App\Enums\TrainingType;
use App\Enums\UserRole;
use App\Http\Builder\Filters\TrainingFilter;
use App\Http\Builder\Sorters\AbstractSorter;
use App\Http\Builder\Sorters\TrainingSorter;
use App\Models\BalanceEvent;
use App\Models\Reservation;
use App\Models\User;
use App\Service\ReservationService;
use App\Service\TrainingService;
use App\View\Components\Reservations\ClientReservations;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Throwable;

class ReservationClientController
{
    public function __construct(
        private readonly TrainingService $trainingService,
        private readonly ReservationService $reservationService,
    ) {}

    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $relations = [
            'instructor',
        ];
        $trainingFilter = new TrainingFilter([
            TrainingFilter::CLIENT_ID => auth()->user()->id,
        ]);
        $trainingSorter = new TrainingSorter([
            TrainingSorter::ORDER_BY_DATETIME_START => AbstractSorter::SORT_DESC,
        ]);

        $trainings = $this->trainingService->index($relations, $trainingFilter, $trainingSorter);

        $instructors = (new User())->newQuery()
            ->where('role', '=', UserRole::INSTRUCTOR->value)
            ->get();

        $trainingsListComponent = new ClientReservations($trainings, $instructors);

        return $trainingsListComponent->render()->with($trainingsListComponent->data());
    }

    /**
     * @param int $trainingId
     * @return RedirectResponse
     */
    public function store(int $trainingId): RedirectResponse
    {
        DB::beginTransaction();
        try {
            /** @var User $user */
            $user = auth()->user();
            $training = $this->trainingService->show($trainingId, [
                'clients',
            ]);

            if (
                $training->type === TrainingType::SINGLE->value
                && $training->clients->isNotEmpty()
                || $training->type === TrainingType::GROUP->value
                && $training->clients->contains('id', '=', $user->id)
            ) {
                throw new RuntimeException('snovaa loh', 200);
            }

            $clientInfo = $user->clientInfo;

            if ($clientInfo->balance < $training->price) {
                throw new RuntimeException('Your balance is low', 200);
            }

            $oldBalance = $clientInfo->balance;
            $clientInfo->balance -= $training->price;
            $clientInfo->save();

            (new BalanceEvent())->newQuery()
                ->create([
                    'client_id' => $user->id,
                    'old_balance' => $oldBalance,
                    'balance_change' =>  $clientInfo->balance - $oldBalance,
                    'description' => sprintf(
                        '%s: %s[ID:%s]',
                        __('gym.standard_balance_training_payment'),
                        $training->name,
                        $training->id,
                    )
                ]);

            (new Reservation())->newQuery()
                ->create([
                    'training_id' => $trainingId,
                    'client_id' => $user->id,
                ]);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
        }

        return redirect()->to(route('trainings.reservations'));
    }

    /**
     * @param int $reservationId
     * @return RedirectResponse
     */
    public function destroy(int $reservationId): RedirectResponse
    {
        DB::beginTransaction();
        try {
            /** @var User $user */
            $user = auth()->user();
            $reservation = $this->reservationService->show($reservationId, [
                'training',
            ]);

            if (
                $reservation->client_id !== $user->id
                || $reservation->training->datetime_start > date('Y-m-d H:i:s', time())
            ) {
                throw new RuntimeException('Дальше вы не пройдете пока не получите бумаги', 403);
            }

            $reservation->delete();

            $clientInfo = $user->clientInfo;
            $oldBalance = $clientInfo->balance;
            $clientInfo->balance += $reservation->training->price;
            $clientInfo->save();

            (new BalanceEvent())->newQuery()
                ->create([
                    'client_id' => $user->id,
                    'old_balance' => $oldBalance,
                    'balance_change' => $reservation->training->price,
                    'description' => sprintf(
                        '%s: %s[ID:%s]',
                        __('gym.balance_training_withdraw'),
                        $reservation->training->name,
                        $reservation->training->id,
                    )
                ]);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
        }

        return redirect()->to(route('trainings.reservations'));
    }
}
