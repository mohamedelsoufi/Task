<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id'=>'required|exists:users,id',
            'name' => 'required|string|max:100',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'image' => 'image|max:10000',
            'is_admin'=> 'required|boolean'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = failureResponse($validator->errors());
        throw new ValidationException($validator,$response);
    }
}
