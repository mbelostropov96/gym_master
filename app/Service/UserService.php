<?php

namespace App\Service;

use App\Models\User;
use App\Service\DTO\UserDTO;

class UserService
{
    public function show(int $id, array $relations = []): User
    {
        /** @var User $user */
        $user = (new User())->newQuery()
            ->with($relations)
            ->findOrFail($id);

        return $user;
    }

    public function update(int $id, UserDTO $userDto): bool
    {
        return (new User())->newQuery()
            ->findOrFail($id)
            ->update($userDto->toArray());
    }

    public function destroy(int $id): ?bool
    {
        return (new User())->newQuery()
            ->findOrFail($id)
            ->delete();
    }
}
