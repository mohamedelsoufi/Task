<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JWTMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status' => '0', 'msg' => 'Token is Invalid', 'data' => []], 200);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['status' => '0', 'msg' => 'Token is Expired', 'data' => []], 200);
            } else {
                return response()->json(['status' => '0', 'msg' => 'Authorization Token not found', 'data' => []], 200);
            }
        }
        return $next($request);
    }
}
