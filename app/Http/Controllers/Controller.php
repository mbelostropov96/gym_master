<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cookie;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function setCookie(string $name, array $value, int $minutes = 60): void
    {
        $value = base64_encode(json_encode($value));
        $minutes = time() + 60 * $minutes;

        Cookie::queue($name, $value, $minutes);
    }

    protected function getCookie(string $name): ?array
    {
        if (empty($name)) {
            return null;
        }

        $cookieValue = Cookie::get($name);

        if (empty($cookieValue)) {
            return null;
        }

        return json_decode(base64_decode($cookieValue), true);
    }

    protected function forgetCookie(string $name): void
    {
        if (!empty($name)) {
            $this->setCookie($name, [], -1);
        }
    }
}
