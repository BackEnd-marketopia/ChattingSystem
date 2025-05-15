<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class packageitemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->routeIs('package-items.store') && $this->user()?->hasanyRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'package_id' => 'required|exists:packages,id',
            'type' => 'required|string',
            'status' => 'required|string',
            'notes' => 'required|string',
            'created_by' => 'required|exists:users,id',
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
            Response::api($errors, 401, false, 401, null)
        );
    }
}
