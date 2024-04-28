<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
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
            ->with([
                'clientInfo',
                'instructorInfo',
            ])
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
