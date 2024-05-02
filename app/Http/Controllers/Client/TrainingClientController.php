<?php

namespace App\Http\Controllers\Client;

use App\Enums\TrainingType;
use App\Enums\UserRole;
use App\Models\BalanceEvent;
use App\Models\ClientInfo;
use App\Models\Reservation;
use App\Models\Training;
use App\Models\User;
use App\View\Components\Reservations\ClientReservations;
use App\View\Components\Trainings\ClientTrainings;
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
                || $training->type === TrainingType::GROUP->value
                 && $training->clients->where('id', '=', auth()->user()->id)->isNotEmpty()
            ) {
                return false;
            }

            return true;
        });

        $instructors = (new User())->newQuery()
            ->where('role', '=', UserRole::INSTRUCTOR->value)
            ->get();

        $trainingsListComponent = new ClientTrainings($trainings, $instructors);

        return $trainingsListComponent->render()->with($trainingsListComponent->data());
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
}
