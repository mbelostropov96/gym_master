<?php

namespace App\Services;

use App\Helpers\UserHelper;
use App\Models\BalanceEvent;
use App\Models\ClientInfo;
use App\Models\Reservation;
use App\Models\Tariff;
use App\Models\User;
use DateTime;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class ReservationService
{
    public function __construct(
        private readonly TrainingService $trainingService,
    ) {
    }

    /**
     * @param int $id
     * @param array|null $relations
     * @return Reservation
     */
    public function show(int $id, array $relations = null): Reservation
    {
        $builder = (new Reservation())->newQuery();

        if ($relations !== null) {
            $builder->with($relations);
        }

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

        $training = $this->trainingService->show($trainingId, [
            'clients',
        ]);

        if (
            $training->max_clients <= $training->clients->count()
            || $training->clients->contains('id', '=', $user->id)
        ) {
            throw new RuntimeException(__('gym.error.reservation.store'), Response::HTTP_BAD_REQUEST);
        }

        $clientInfo = $user->clientInfo;

        if ($clientInfo->balance < $training->price) {
            throw new RuntimeException(__('gym.error.reservation.balance_is_low'), Response::HTTP_BAD_REQUEST);
        }

        /** @var Tariff $clientTariff */
        $clientTariff = (new Tariff())->newQuery()
            ->findOrFail($clientInfo->tariff_id);

        $trainingPrice = (int)ceil($training->price * ((100 - $clientTariff->discount) / 100));

        $oldBalance = $clientInfo->balance;
        $clientInfo->balance -= $trainingPrice;
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
                'price' => $trainingPrice,
            ]);
    }

    /**
     * @param int $reservationId
     * @return void
     */
    public function destroy(int $reservationId): void
    {
        /** @var User $user */
        $user = auth()->user();

        $reservation = $this->show($reservationId, [
            'training',
        ]);

        $reservationIsExpired = $reservation->training->datetime_start > new DateTime();

        if (
            !UserHelper::isAdmin()
            && (
                $reservation->client_id !== $user->id
                || $reservationIsExpired
            )
        ) {
            throw new RuntimeException('Дальше вы не пройдете пока не получите бумаги', 403);
        }

        $reservation->delete();

        if (!$reservationIsExpired) {
            /** @var ClientInfo $clientInfo */
            $clientInfo = (new ClientInfo())->newQuery()
                ->where('client_id', '=', $reservation->client_id)
                ->first();
            $oldBalance = $clientInfo->balance;
            $clientInfo->balance += $reservation->price;
            $clientInfo->save();

            (new BalanceEvent())->newQuery()
                ->create([
                    'client_id' => $clientInfo->client_id,
                    'old_balance' => $oldBalance,
                    'balance_change' => $reservation->price,
                    'description' => sprintf(
                        '%s: %s[ID:%s]',
                        __('gym.balance_training_withdraw'),
                        $reservation->training->name,
                        $reservation->training->id,
                    )
                ]);
        }
    }
}
