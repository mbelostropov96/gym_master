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
use App\View\Components\Admin\Users as UsersComponent;
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

        $usersComponent = new UsersComponent($users);

        return $usersComponent->render()->with($usersComponent->data());
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

        $userComponent = new UserComponent($user);

        return $userComponent->render()->with($userComponent->data());
    }

    /**
     * @param int $id
     * @param UpdateUserRequest $request
     * @return RedirectResponse
     */
    public function update(int $id, UpdateUserRequest $request): RedirectResponse
    {
        $data = $request->validated();

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
                'description' => __('gym.standard_balance_top_up'),
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
