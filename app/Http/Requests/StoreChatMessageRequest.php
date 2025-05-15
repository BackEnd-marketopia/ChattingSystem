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
            'file' => 'nullable|file|max:2097152',
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
