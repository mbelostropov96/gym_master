<?php

namespace App\Service;

use App\Enums\TrainingType;
use App\Models\BalanceEvent;
use App\Models\Reservation;
use App\Models\User;
use RuntimeException;

class ReservationService
{
    /**
     * @param int $id
     * @param array|null $relations
     * @return Reservation
     */
    public function show(int $id, array $relations = null): Reservation
    {
        $builder = (new Reservation())->newQuery();

        if ($relations !== null) $builder->with($relations);

        /** @var Reservation $reservation */
        $reservation = $builder->findOrFail($id);

        return $reservation;
    }

    /**
     * @param int $trainingId
     * @param int|null $userId
     * @return void
     */
    public function store(int $trainingId, int $userId = null): void
    {
        /** @var User $user */
        $user = $userId === null
            ? auth()->user()
            : (new User())->newQuery()->findOrFail($userId);

        $training = (new TrainingService())->show($trainingId, [
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
                'balance_change' => $clientInfo->balance - $oldBalance,
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
    }

    /**
     * @param int $reservationId
     * @param int|null $userId
     * @return void
     */
    public function destroy(int $reservationId, int $userId = null): void
    {
        /** @var User $user */
        $user = $userId === null
            ? auth()->user()
            : (new User())->newQuery()->findOrFail($userId);

        $reservation = $this->show($reservationId, [
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
    }
}
