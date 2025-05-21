<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Response;


class ClientPackageItemRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'item_type' => 'required|in:post,design,video,photo,reel,ugc,profile,ads,document,link,other',
            'package_item_id' => 'nullable|exists:package_items,id',
            'client_package_id' => "nullable|exists:client_package,id",
            'content' => 'nullable|string',
            'client_note' => 'nullable|string',
            'media' => 'nullable|file|max:2097152', // max 2GB
            'status' => 'nullable|in:pending,accepted,declined,edited',
            'handled_by' => 'nullable|exists:users,id',
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
