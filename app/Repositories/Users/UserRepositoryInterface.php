<?php

namespace App\Repositories\Users;

interface UserRepositoryInterface
{
    public function getAllUsers();

    public function getUserById($request);

    public function authUser();

    public function register($request);

    public function updateUser($request);
}
