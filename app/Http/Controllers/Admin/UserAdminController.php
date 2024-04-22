<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditUserRequest;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

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
            ->findOrFail($id);

        return view('', [
            'user' => $user,
        ]);
    }

    /**
     * @param int $id
     * @param EditUserRequest $request
     * @return RedirectResponse
     */
    public function update(int $id, EditUserRequest $request): RedirectResponse
    {
        (new User())->newQuery()
            ->findOrFail($id)
            ->update($request->validated());

        return redirect('');
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

        return redirect('users.index');
    }
}
