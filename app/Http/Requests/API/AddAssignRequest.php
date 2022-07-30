<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class AddAssignRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:reviews,id',
            'assign_to' => 'nullable|array',
            'assign_to.*' => 'exists:users,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = failureResponse($validator->errors());
        throw new ValidationException($validator,$response);
    }
}
