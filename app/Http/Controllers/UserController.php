<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteUserByEmailRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getUsersWithTasks()
    {
        return $this->userService->getUsersWithTasks();
    }

    public function getUsers(Request $request)
    {
        return $this->userService->getUsers($request);
    }

    public function deleteUserByEmail(DeleteUserByEmailRequest $request)
    {
        return $this->userService->deleteUserByEmail($request);
    }
}
