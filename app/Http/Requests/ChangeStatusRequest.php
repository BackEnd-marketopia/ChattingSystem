<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Response;


class ChangeStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_package_id' => 'required|exists:client_package,id',
            'item_type' => 'required|string|exists:item_types,name',
            'item_id' => 'required|integer|exists:package_items,type_id',
            'status' => 'required|in:pending,accepted,declined,edited',
            'note' =>  'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->first();

        throw new HttpResponseException(
            Response::api($errors, 405, false, 405, null)
        );
    }
}
