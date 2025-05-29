<?php

// app/Http/Requests/StoreChatMessageRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Response;

class StoreChatMessageRequest extends FormRequest
{
    public function authorize()
    {
        return $this->routeIs('sendmessage') && $this->user()?->hasanyRole('admin', 'team', 'client');
    }

    public function rules()
    {
        return [
            'senderId' => 'required|exists:users,id',
            'message' => 'nullable|string',
            'media.*' => 'nullable|file|max:2097152',
            'media' => 'nullable|array',
            'client_package_item_id' => 'nullable|exists:client_package_items,id',

            'item_type' => 'nullable|string',
            'package_item_id' => 'nullable|exists:package_items,id',
            'client_package_id' => "nullable|exists:client_package,id",
            'client_note' => 'nullable|string',
            'IsItem' => 'nullable|boolean'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->first();

        throw new HttpResponseException(
            Response::api($errors, 405, false, 405, null)
        );
    }

    public function messages()
    {
        return [];
    }
}
