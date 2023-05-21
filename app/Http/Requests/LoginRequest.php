<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */


    public function rules(): array
    {
        return [
            'username'    => 'required|string',
            'password'    => 'required|max:255',
            'remember_me' => 'nullable',
        ];
    }
}
