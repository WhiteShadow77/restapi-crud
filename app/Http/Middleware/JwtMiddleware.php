<?php

namespace App\Http\Middleware;

use App\Services\ResponseService;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        $responseService = App::make(ResponseService::class);

        try {

            $this->auth = JWTAuth::parseToken()->authenticate();

            if (!$this->auth) {
                return $responseService->errorResponse('Unauthorized', 401);
            }

        } catch (JWTException $e) {

            return $responseService->errorResponse('Unauthorized', 401);
        }


        return $next($request);
    }
}
