<?php
const PAGINATION_COUNT = 15;

function successResponse($data = [])
{
    return response()->json(['status' => 1, 'msg' => 'success', 'data' => $data], 200);
}

function failureResponse($data = [])
{
    return response()->json(['status' => 0, 'msg' => 'error', 'data' => $data], 400);
}

function getAuthAPIUser()
{
    $user = \auth('api')->user();
    if (!$user)
        return failureResponse('user not registered');
    return $user;
}

