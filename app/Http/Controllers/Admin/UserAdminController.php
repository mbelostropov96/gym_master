<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\BalanceEvent;
use App\Models\ClientInfo;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

class UserAdminController extends Controller
{
    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $users = (new User())->newQuery()
            ->get();

        return view('profile.admin.users', [
            'users' => $users,
        ]);
    }

    /**
     * @param int $id
     * @return Renderable
     */
    public function show(int $id): Renderable
    {
        $user = (new User())->newQuery()
            ->with([
                'clientInfo',
                'instructorInfo',
            ])
            ->findOrFail($id);

        return view('profile.admin.user', [
            'user' => $user,
        ]);
    }

    /**
     * @param int $id
     * @param UpdateUserRequest $request
     * @return RedirectResponse
     */
    public function update(int $id, UpdateUserRequest $request): RedirectResponse
    {
        $data = $request->all();

        (new User())->newQuery()
            ->findOrFail($id)
            ->update($data);

        return redirect()->to(route('users.update', ['id' => $id]));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateBalance(int $id, Request $request): RedirectResponse
    {
        $balance = (int)$request->get('balance');

        /** @var ClientInfo $clientInfo */
        $clientInfo = (new ClientInfo())->newQuery()
            ->where('client_id', '=', $id)
            ->first();

        $currentBalance = $clientInfo->balance;
        $newBalance = $balance + $currentBalance;

        if ($newBalance < 0) {
            throw new RuntimeException('ti loh', 228);
        }

        $clientInfo->update([
            'balance' => $newBalance,
        ]);

        (new BalanceEvent())->newQuery()
            ->create([
                'client_id' => $id,
                'old_balance' => $currentBalance,
                'balance_change' => $balance,
                'description' => 'Деньги не сделают тебя счастливее. Сейчас у меня 50 миллионов, и я так же счастлив, как и тогда, когда у меня было 48 миллионов',
            ]);

        return redirect()->to(route('users.show', ['id' => $id]));
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        (new User())->newQuery()
            ->findOrFail($id)
            ->delete();

        return redirect()->to(route('users.index'));
    }
}
