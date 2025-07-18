<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Response;


class ClientLimitRequest extends FormRequest
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
            'client_id' => 'required|exists:users,id',
            'client_package_id' => 'required|exists:client_package,id',
            // 'client_package_item_id' => [
            //     'required',
            //     'exists:client_package_items,id',
            //     'unique:client_limits,client_package_item_id,NULL,id,client_id,' . $this->client_id,
            // ],
            // 'item_type' => 'required|string',
            'item_type' => [
                'required',
                'string',
                // يمنع تكرار نفس الـ item_type مع نفس الـ client_package_id
                'unique:client_limits,item_type,NULL,id,client_package_id,' . $this->client_package_id,
            ],
            'edit_limit' => 'required|integer|min:0',
            'decline_limit' => 'required|integer|min:0',
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
            Response::api($errors, 409, false, 409, null)
        );
    }
}
