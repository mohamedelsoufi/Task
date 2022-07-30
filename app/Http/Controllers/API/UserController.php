<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ShowUserRequest;
use App\Http\Requests\API\StoreUserRequest;
use App\Http\Requests\API\UpdateUserRequest;
use App\Models\User;
use App\Repositories\Users\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // get users
    public function index(){
        return $this->userRepository->getAllUsers();
    }

    // show user by id
    public function show(ShowUserRequest $request){
        return $this->userRepository->getUserById($request);
    }

    // profile
    public function profile(){
        return $this->userRepository->authUser();
    }

    //store new user
    public function store(StoreUserRequest $request)
    {
        return $this->userRepository->register($request);
    }

    //update new user
    public function update(UpdateUserRequest $request)
    {
        return $this->userRepository->updateUser($request);
    }

    // delete user
    public function delete(ShowUserRequest $request)
    {
        return $this->userRepository->deleteUser($request);
    }

    public function myAssignments(){
        return $this->userRepository->myAssignments();
    }
}
