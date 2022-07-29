<?php

namespace App\Repositories\Auth;


use App\Http\Requests\API\StoreUserRequest;

interface AuthRepositoryInterface
{
    public function login();

    public function logout();

    public function refresh();

}
