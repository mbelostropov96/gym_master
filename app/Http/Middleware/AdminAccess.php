<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user || $user->role !== UserRole::ADMIN->value) {
            return redirect(route('profile'));
        }

        return $next($request);
    }
}
