<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\UpdateUserRequest;
use App\Service\DTO\UserDTO;
use App\Service\UserService;
use App\View\Components\Admin\User\User as UserComponent;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use RuntimeException;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    /**
     * @param int $id
     * @return Renderable
     */
    public function show(int $id): Renderable
    {
        $relations = match (auth()->user()->role) {
            UserRole::CLIENT->value => [
                'clientInfo',
                'balanceEvents',
            ],
            UserRole::INSTRUCTOR->value => [
                'instructorInfo',
            ],
            default => [],
        };

        $user = $this->userService->show($id, $relations);

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
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        if ($id !== auth()->user()->id) {
            throw new RuntimeException('looooh', 200);
        }

        $this->userService->destroy($id);

        return redirect()->to(route('admin.users.index'));
    }
}
