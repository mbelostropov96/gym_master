<?php

namespace App\View\Components\Profile;

use App\Enums\UserRole;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class GeneralInfo extends Component
{
    public array $contents;

    public function __construct()
    {
        /** @var User $user */
        $user = Auth::user()->load(['clientInfo', 'instructorInfo']);

        $this->contents = $this->addDisplayDataByRole($user);
    }

    public function render(): View|Closure|string
    {
        return view('components.profile.general-info');
    }

    private function addDisplayDataByRole(User $user): array
    {
        return match ($user->role) {
            UserRole::ADMIN->value => [
                __('gym.role') => $user->role,
                __('gym.first_name') => $user->first_name,
                __('gym.email') => $user->email,
            ],
            UserRole::CLIENT->value => [
                __('gym.user_id') => $user->id,
                __('gym.first_name') => $user->first_name,
                __('gym.last_name') => $user->last_name,
                __('gym.middle_name') => $user->middle_name,
                __('gym.email') => $user->email,
                __('gym.role') => $user->role,
                __('gym.balance') => $user->clientInfo?->balance . ' ' . __('gym.currency_symbol'),
                __('gym.tariff') => $user->clientInfo?->tariff_id
            ],
            UserRole::INSTRUCTOR->value => [
                __('gym.user_id') => $user->id,
                __('gym.first_name') => $user->first_name,
                __('gym.last_name') => $user->last_name,
                __('gym.middle_name') => $user->middle_name,
                __('gym.email') => $user->email,
                __('gym.role') => $user->role,
                __('gym.instructor_experience') => $user->instructorInfo?->experience,
                __('gym.instructor_qualification') => $user->instructorInfo?->qualification
            ],
            default => [],
        };
    }
}
