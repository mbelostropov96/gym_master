<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditUserRequest;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;

class UserController extends Controller
{
    /**
     * @return Factory|Application|View|ApplicationContract
     */
    public function index(): Factory|Application|View|ApplicationContract
    {
        $users = (new User())->newQuery()
            ->get();

        return view('profile.admin.index_users', [
            'users' => $users,
        ]);
    }

    /**
     * @param int $id
     * @return Factory|Application|View|ApplicationContract
     */
    public function show(int $id): Factory|Application|View|ApplicationContract
    {
        $user = (new User())->newQuery()
            ->findOrFail($id);

        return view('', [
            'user' => $user,
        ]);
    }

    /**
     * @param EditUserRequest $request
     * @return Factory|Application|View|ApplicationContract
     */
    public function update(EditUserRequest $request): Factory|Application|View|ApplicationContract
    {
        (new User())->newQuery()
            ->findOrFail($request['id'])
            ->update($request->validated());

        return view('');
    }

    /**
     * @param int $id
     * @return Factory|Application|View|ApplicationContract
     */
    public function destroy(int $id): Factory|Application|View|ApplicationContract
    {
        (new User())->newQuery()
            ->findOrFail($id)
            ->delete();

        return redirect('users.index');
    }
}
