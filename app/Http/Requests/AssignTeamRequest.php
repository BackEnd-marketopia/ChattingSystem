<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Response;

class AssignTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->routeIs('assignteam') && $this->user()?->hasanyRole('admin');
    }

    public function rules(): array
    {
        return [
            'team_ids' => 'required|array',
            'team_ids.*' => 'exists:users,id'
        ];
    }

    public function messages(): array
    {
        return [];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->first();

        throw new HttpResponseException(
            Response::api($errors, 422, false, 422, null)
        );
    }
}
