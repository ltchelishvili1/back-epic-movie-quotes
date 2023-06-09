<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'username'       => 'nullable|min:3|max:255|unique:users,username',
            'email'          => 'nullable|email|max:255|unique:users,email',
            'password'       => 'nullable|min:3|max:255',
            'photo'     =>'image'
        ];
    }
}
