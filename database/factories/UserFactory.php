<?php

namespace Database\Factories;

use App\Enums\UserRoles;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => 'admin',
            'middle_name' => '',
            'last_name' => '',
            'email' => 'admin',
            'password' => Hash::make('12345678'),
            'role' => UserRoles::CLIENT->value,
            'remember_token' => Str::random(10),
        ];
    }
}
