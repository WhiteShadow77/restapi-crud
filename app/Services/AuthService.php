<?php

namespace App\Services;


use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthService
{

    public function __construct(private ResponseService $responseService)
    {
    }

    public function login(string $email, string $password)
    {
        $credentials = [
            'email' => $email,
            'password' =>$password
        ];

        if (!$token = auth()->attempt($credentials)) {
            return $this->responseService->errorResponse('Unauthorized', 401);
        }

        return $this->responseService->successResponseWithKeyValueData([
            'data' => [
                'role' => Auth::user()->role->type,
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ], 'Successfully logged in');
    }

    public function logout()
    {
        auth()->logout();

        return $this->responseService->successResponse('Successfully logged out');
    }

    public function refresh()
    {
        return $this->responseService->successResponseWithKeyValueData([
            'data' => [
                'access_token' => auth()->refresh(),
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ], 'Successfully refreshed');
    }
}