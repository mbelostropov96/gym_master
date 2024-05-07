<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\DTO\UserDTO;
use App\Services\UserService;
use App\View\Components\Admin\User\User as UserComponent;
use App\View\Components\Profile\Profile;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use RuntimeException;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {
        parent::__construct();
    }

    /**
     * @return Renderable
     */
    public function profile(): Renderable
    {
        /** @var User $user */
        $user = auth()->user();
        $relations = match ($user->role) {
            UserRole::CLIENT->value => [
                'clientInfo',
                'balanceEvents',
            ],
            UserRole::INSTRUCTOR->value => [
                'instructorInfo',
                'ratings',
            ],
            default => [],
        };

        $user->load($relations);

        // TODO будущий профиль?
        $userComponent = new UserComponent($user);

        return (new Profile())->render();
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

    /**
     * @param int $id
     * @return Renderable
     */
    public function showInstructor(int $id): Renderable
    {
        $instructor = (new User())->newQuery()
            ->where('role', '=', UserRole::INSTRUCTOR->value)
            ->with([
                'instructorInfo',
                'ratings',
            ])
            ->findOrFail($id);

        // TODO add cumponent
    }
}
