<?php


namespace App\Services;


use App\Models\User;
use Carbon\Carbon;

class AuthService
{
    /**
     * @param $credentials
     * @return bool | string
     */
    public function login($credentials)
    {
        if (! $token = auth()->attempt($credentials)) {
            return false;
        }

        return $token;
    }

    public function logout()
    {
        auth()->logout();
    }

    /**
     * @return mixed
     */
    public function refresh()
    {
        return auth()->refresh();
    }
}
