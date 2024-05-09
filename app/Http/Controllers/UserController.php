<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\UpdateClientInfoRequest;
use App\Http\Requests\UpdateInstructorInfoRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\InstructorInfo;
use App\Models\Tariff;
use App\Models\User;
use App\Services\ClientTrainings\AbstractClientTraining;
use App\Services\ClientTrainings\ClientTrainingFactory;
use App\Services\DTO\UserDTO;
use App\Services\UserService;
use App\View\Components\Admin\User\User as UserComponent;
use App\View\Components\Instructor\InstructorCard;
use App\View\Components\Profile\Profile;
use App\View\Components\Tariff\Tariffs;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

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

        $trainings = (new ClientTrainingFactory())->create(AbstractClientTraining::HISTORY)->index();
        $availableTariffs = (new Tariff())->newQuery()
            ->where('id', '>', $user->clientInfo->tariff_id) // это что за мегакринж. типа мы только в порядке возрастания тариф создать можем?
//            ->where('number_of_trainings', '<=', $trainings->count())
            ->get();

        // TODO будущий профиль?
        $userComponent = new UserComponent($user);

        return (new Profile())->render();
    }

    /**
     * @return Renderable
     */
    public function tariffs(): Renderable
    {
        /** @var User $user */
        $user = auth()->user();
        $relations = match ($user->role) {
            UserRole::CLIENT->value => [
                'clientInfo',
                'balanceEvents',
            ],
            default => [],
        };

        $user->load($relations);

        $trainings = (new ClientTrainingFactory())->create(AbstractClientTraining::HISTORY)->index();
        $tariffs = (new Tariff())->newQuery()
            ->where('id', '!=', $user->clientInfo->tariff_id)
            ->get();

        $tariffsComponent = new Tariffs($tariffs, $trainings->count());

        return $tariffsComponent->render()->with($tariffsComponent->data());
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
     * @param UpdateClientInfoRequest $request
     * @return RedirectResponse
     */
    public function updateClientInfo(UpdateClientInfoRequest $request): RedirectResponse
    {
        $data = $request->validated();

        /** @var User $user */
        $user = auth()->user();
        $clientInfo = $user->clientInfo;

        if ($clientInfo->client_id !== $user->id) {
            throw new RuntimeException('sosi loh', Response::HTTP_FORBIDDEN);
        }

        $clientInfo->update($data);

        return redirect()->to(route('profile'));
    }

    /**
     * Сделай плес
     *  нужно создавать или апдейтить
     * */
    public function updateInstructorInfo(UpdateInstructorInfoRequest $request): RedirectResponse
    {
        $data = $request->validated();

        /** @var User $user */
        $user = auth()->user();

        if ($user->role !== UserRole::INSTRUCTOR->value) {
            throw new RuntimeException('ny loh je', Response::HTTP_FORBIDDEN);
        }

        (new InstructorInfo())->newQuery()
            ->updateOrCreate(
                [
                    'instructor_id' => $user->id,
                ],
                $data,
            );

        return redirect()->to(route('profile'));
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
        /** @var User $instructor */
        $instructor = (new User())->newQuery()
            ->where('role', '=', UserRole::INSTRUCTOR->value)
            ->with([
                'instructorInfo',
                'ratings',
            ])
            ->findOrFail($id);

        $instructorComponent = new InstructorCard($instructor);

        return $instructorComponent->render()->with($instructorComponent->data());
    }
}
