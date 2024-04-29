<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\BalanceEvent;
use App\Models\ClientInfo;
use App\Models\User;
use App\Service\DTO\UserDTO;
use App\Service\UserService;
use App\View\Components\Admin\User as UserComponent;
use App\View\Components\Admin\Users;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

class UserAdminController extends Controller
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $users = (new User())->newQuery()
            ->get();

        $attributeNameMap = [
            'id' => 'ID',
            'last_name' => __('gym.last_name'),
            'first_name' => __('gym.first_name'),
            'middle_name' => __('gym.middle_name'),
            'email' => __('gym.email'),
            'role' => __('gym.role'),
        ];

        return (new Users($attributeNameMap, $users))->render();
    }

    /**
     * @param int $id
     * @return Renderable
     */
    public function show(int $id): Renderable
    {
        $user = $this->userService->show($id, [
            'clientInfo',
            'instructorInfo',
            'balanceEvents',
        ]);

        return (new UserComponent($user))->render();
    }

    /**
     * @param int $id
     * @param UpdateUserRequest $request
     * @return RedirectResponse
     */
    public function update(int $id, UpdateUserRequest $request): RedirectResponse
    {
        $data = $request->validatedWithCasts();

        $this->userService->update($id, new UserDTO($data));

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
        $this->userService->destroy($id);

        return redirect()->to(route('users.index'));
    }
}
