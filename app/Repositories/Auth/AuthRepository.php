<?php


namespace App\Repositories\Auth;


use App\Http\Requests\API\StoreUserRequest;
use App\Http\Resources\Users\GetUsersResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthRepository implements AuthRepositoryInterface
{
    //login
    public function login()
    {
        $credentials = ['email' => \request()->email, 'password' => \request()->password];

        if (!$token = auth('api')->attempt($credentials)) {
            return failureResponse('Unauthorized');
        }
        return successResponse(['token' => $token, 'user' => new GetUsersResource(\auth('api')->user())]);
    }

    //logout
    public function logout()
    {
        try {
            auth('api')->logout();
            auth('api')->invalidate();
            return successResponse();
        } catch (\Exception $e) {
            return failureResponse($e->getMessage());
        }
    }

    // refresh token
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    //respond with token
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }


}
