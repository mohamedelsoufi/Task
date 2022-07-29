<?php


namespace App\Repositories\Users;


use App\Http\Resources\Users\GetUsersResource;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\File;

class UserRepository implements UserRepositoryInterface
{
    // get all users start
    public function getAllUsers()
    {
        try {
            $users = User::latest('id')->paginate(PAGINATION_COUNT);

            return successResponse(GetUsersResource::collection($users)->response()->getData(true));
        } catch (\Exception $e) {
            return failureResponse($e->getMessage());
        }
    }// get all users end


    // get user by ID start
    public function getUserById($request)
    {
        try {
            $user = User::find($request->user_id);
            return successResponse(new GetUsersResource($user));
        } catch (\Exception $e) {
            return failureResponse($e->getMessage());
        }
    }// get user by ID end

    // show authenticated user profile
    public function authUser()
    {
        try {
            $user = auth('api')->user();
            return successResponse(new GetUsersResource($user));
        } catch (\Exception $e) {
            return failureResponse($e->getMessage());
        }
    }// end authenticated user profile

    // create user start
    public function register($request)
    {
        try {
            $requested_data = $request->except(['image']);

            if ($request->has('image')) {
                $image = $request->image->store('profile_images');
                $requested_data['image'] = $image;
            }
            $requested_data['image'] = $image;
            $user = User::create($requested_data);
            $token = JWTAuth::fromUser($user);
            return successResponse(['token' => $token, 'user' => new GetUsersResource(\auth('api')->user())]);
        } catch (\Exception $e) {
            return failureResponse($e->getMessage());
        }

    }// create user end

    // update user start
    public function updateUser($request)
    {
        try {
            $auth_user = auth('api')->user();

            $user = User::find($request->user_id);

            if ($auth_user->is_admin == 0)
                return failureResponse("You don't have Admin access to edit users");

            $request->merge([
                'id' => $request->user_id
            ]);

            $requested_data = $request->except(['user_id','image']);

            if ($request->has('image')) {
                $image_path = public_path('uploads/');
                if (File::exists($image_path . $user->getRawOriginal('image'))) {
                    File::delete($image_path . $user->getRawOriginal('image'));
                }

                $image = $request->image->store('profile_images');
                $requested_data['image'] = $image;
            }

            $user->update($requested_data);
            $get_user = $user->refresh();

            return successResponse(new GetUsersResource($get_user));
        } catch (\Exception $e) {
            return failureResponse($e->getMessage());
        }
    }//end of update user

}