<?php

namespace App\Services;


use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;

class UserService
{
    private ResponseService $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function getUsersWithTasks()
    {
        $users = DB::table('users')
            ->join('tasks', 'users.id', '=', 'tasks.user_id')
            ->selectRaw('email as user_email, count(email) as tasks_quantity')
            ->groupBy('email')
            ->get();

        return $this->responseService->successResponseWithResourceCollection(
            'Users with tasks',
            UserResource::class,
            $users
        );
    }
}