<?php

namespace App\Http\Controllers\Client;

use App\Enums\TrainingType;
use App\Enums\UserRole;
use App\Http\Builder\Filters\TrainingFilter;
use App\Http\Builder\Sorters\AbstractSorter;
use App\Http\Builder\Sorters\TrainingSorter;
use App\Models\BalanceEvent;
use App\Models\ClientInfo;
use App\Models\Reservation;
use App\Models\Training;
use App\Models\User;
use App\Service\TrainingService;
use App\View\Components\Reservations\ClientReservations;
use App\View\Components\Trainings\ClientTrainings;
use App\View\Components\Trainings\TrainingCard;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class TrainingClientController
{
    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $trainingFilter = new TrainingFilter([
            TrainingFilter::MORE_DATETIME_START => date('Y-m-d H:i:s', time()),
        ]);
        $trainingSorter = new TrainingSorter([
            TrainingSorter::ORDER_BY_DATETIME_START => AbstractSorter::SORT_ASC,
        ]);
        $relations = [
            'clients',
            'instructor',
        ];

        $trainings = (new TrainingService())->index($trainingFilter, $trainingSorter, $relations);

        $trainings = $trainings->filter(static function (Training $training) {
            if (
                $training->type === TrainingType::SINGLE->value
                && $training->clients->isNotEmpty()
                || $training->type === TrainingType::GROUP->value
                && $training->clients->contains('id', '=', auth()->user()->id)
            ) {
                return false;
            }

            return true;
        });

        // TODO выпилить. Инструктора есть в тренировках
        $instructors = (new User())->newQuery()
            ->where('role', '=', UserRole::INSTRUCTOR->value)
            ->get();

        $trainingsListComponent = new ClientTrainings($trainings, $instructors);

        return $trainingsListComponent->render()->with($trainingsListComponent->data());
    }

    /**
     * @param int $id
     * @return Renderable
     */
    public function show(int $id): Renderable
    {
        /** @var Training $training */
        $training = (new Training())->newQuery()
            ->with([
                'instructor',
                'clients',
            ])
            ->findOrFail($id);

        $trainingComponent = new TrainingCard(
            $training,
        );

        return $trainingComponent->render()->with($trainingComponent->data());
    }

    /**
     * @return Renderable
     */
    public function reservations(): Renderable
    {
        $trainings = (new Training())->newQuery()
            ->with([
                'instructor',
            ])
            ->join(Reservation::TABLE, static function (JoinClause $join) {
                $join->on(
                    sprintf('%s.training_id',Reservation::TABLE),
                    '=',
                    sprintf('%s.id',Training::TABLE)
                );
            })
            ->where(sprintf('%s.client_id',Reservation::TABLE), '=', auth()->user()->id)
            ->orderByDesc(sprintf('%s.id',Reservation::TABLE))
            ->get();

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
    public function reserve(int $trainingId): RedirectResponse
    {
        DB::beginTransaction();
        try {
            /** @var Training $training */
            $training = (new Training())->newQuery()
                ->with([
                    'clients'
                ])
                ->findOrFail($trainingId);

            if (
                $training->type === TrainingType::SINGLE->value
                && $training->clients->isNotEmpty()
                || $training->type === TrainingType::GROUP->value
                && $training->clients->where('id', '=', auth()->user()->id)->isNotEmpty()
            ) {
                throw new \RuntimeException('snovaa loh', 200);
            }

            /** @var ClientInfo $clientInfo */
            $clientInfo = (new ClientInfo())->newQuery()
                ->where('client_id', '=', auth()->user()->id)
                ->first();

            if ($clientInfo->balance < $training->price) {
                throw new \RuntimeException('Your balance is low', 200);
            }

            $oldBalance = $clientInfo->balance;
            $clientInfo->balance = $clientInfo->balance - $training->price;
            $clientInfo->save();

            (new BalanceEvent())->newQuery()
                ->create([
                    'client_id' => auth()->user()->id,
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
                    'client_id' => auth()->user()->id,
                ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
        }

        return redirect()->to(route('trainings.reservations'));
    }

    /**
     * @param int $trainingId
     * @return RedirectResponse
     */
    public function destroyReservation(int $trainingId): RedirectResponse
    {
        try {
            /** @var Training $training */
            $training = (new Training())->newQuery()
                ->findOrFail($trainingId);

            /** @var Reservation $reservation */
            $reservation = (new Reservation())->newQuery()
                ->where('client_id', '=', auth()->user()->id)
                ->where('training_id', '=', $trainingId)
                ->firstOrFail();

            $reservation->delete();

            /** @var ClientInfo $clientInfo */
            $clientInfo = (new ClientInfo())->newQuery()
                ->where('client_id', '=', auth()->user()->id)
                ->first();

            $oldBalance = $clientInfo->balance;
            $clientInfo->balance += $training->price;
            $clientInfo->save();

            (new BalanceEvent())->newQuery()
                ->create([
                    'client_id' => auth()->user()->id,
                    'old_balance' => $oldBalance,
                    'balance_change' => $training->price,
                    'description' => sprintf(
                        '%s: %s[ID:%s]',
                        __('gym.balance_training_withdraw'),
                        $training->name,
                        $training->id,
                    )
                ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
        }

        return redirect()->to(route('trainings.reservations'));
    }
}
