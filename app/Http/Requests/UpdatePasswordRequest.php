<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email'          => 'required|max:255',
            'token'          => 'required|max:255',
            'password'       => 'required|min:3|max:255',
            'repeat_password'=> 'required|same:password',
        ];

    }
}
