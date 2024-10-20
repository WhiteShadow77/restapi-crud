<?php

namespace App\Services;


use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
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
            ->selectRaw('email as user_email, count(email) as task_quantity')
            ->groupBy('email')
            ->get();

        return $this->responseService->successResponseWithResourceCollection(
            'Users with tasks',
            UserResource::class,
            $users
        );
    }

    public function getUsers(Request $request)
    {
        if ($request->has('email')) {

            //DB::connection()->enableQueryLog();

            $users = DB::table('users')
                ->join('tasks', 'users.id', '=', 'tasks.user_id')
                ->join('categories', 'tasks.category_id', '=', 'categories.id')
                ->whereRaw('users.email = ?', $request->email)
                ->selectRaw(
                    'categories.name as category_name, count(categories.name) as task_quantity'
                )
                ->groupBy(['categories.name','users.email'])
                ->get();


            //$users = User::where('email', $request->email)->with('tasks')->get();

            //dd($email);

            //dd(DB::getQueryLog());
            ///"query" => "select * from `users` where `email` = ?"
            /// "query" => "select * from `tasks` where `tasks`.`user_id` in (1)"

            if (sizeof($users) == 0) {

                return $this->responseService->errorResponse('User not found', 404);

            } else {

//                dd( $users[0]);
//                $email = $users[0]->user_email;
//
//                foreach ($users as $user){
//                    unset($user['user_email']);
//                }

                return $this->responseService->successResponseWithResourceCollection(
                    'User by email',
                    UserResource::class,
                    $users,
                    ['email' => $request->email]
                );
            }
        } else {
            return $this->responseService->successResponseWithResourceCollection(
                'All users',
                UserResource::class,
                User::all()
            );
        }
    }
}