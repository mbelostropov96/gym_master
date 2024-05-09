<?php

namespace App\View\Components\Profile;

use App\Enums\UserRole;
use App\Models\Tariff;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class GeneralInfo extends Component
{
    public array $contents;

    public function __construct(
        public readonly Collection $tariffs,
    ) {
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
        $tariffOutput = __('gym.tariff_standard');
        $tariffId = (int)$user->clientInfo?->tariff_id;
        if ($tariffId > 0) {
            /** @var Tariff $tariff */
            $tariff = $this->tariffs->where('id', '=', $tariffId)->first();
            $tariffOutput = $tariff !== null ? __(
                'gym.tariff_text',
                [
                    'name' => $tariff->name,
                    'discount' => $tariff->discount,
                ],
            ) : $tariffId;
        }

        return match ($user->role) {
            UserRole::ADMIN->value => [
                __('gym.role') => $user->role,
                __('gym.email') => $user->email,
            ],
            UserRole::CLIENT->value => [
                __('gym.user_id') => $user->id,
                __('gym.role') => $user->role,
                __('gym.balance') => $user->clientInfo?->balance . ' ' . __('gym.currency_symbol'),
                __('gym.tariff') => $tariffOutput,
            ],
            UserRole::INSTRUCTOR->value => [
                __('gym.user_id') => $user->id,
                __('gym.role') => $user->role,
            ],
            default => [],
        };
    }
}
