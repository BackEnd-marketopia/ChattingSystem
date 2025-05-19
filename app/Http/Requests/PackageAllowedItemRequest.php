<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Response;

class PackageAllowedItemRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'package_item_id' => 'required|exists:package_items,id',
            'allowed_count' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->first();
        throw new HttpResponseException(
            Response::api($errors, 401, false, 401, null)
        );
    }
}
