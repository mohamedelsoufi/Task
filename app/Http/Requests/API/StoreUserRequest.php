<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'image' => 'nullable|image|max:10000',
            'is_admin'=> 'required|boolean'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = failureResponse($validator->errors());
        throw new ValidationException($validator,$response);
    }
}
