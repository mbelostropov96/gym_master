<?php

namespace App\Service\DTO;

use Illuminate\Support\Str;

class UserDTO extends AbstractDTO
{
    public readonly int|string $id;
    public readonly string $firstName;
    public readonly string $middleName;
    public readonly string $lastName;
    public readonly string $email;
    public readonly string $password;
    public readonly string $role;
    public readonly string $rememberToken;
    public readonly string $createdAt;
    public readonly string $updatedAt;

    public function __construct(array $data) {
        foreach ($data as $key => $datum) {
            $property = Str::camel($key);
            if (property_exists($this, $property)) {
                $this->{$property} = $datum;
            }
        }
    }
}
