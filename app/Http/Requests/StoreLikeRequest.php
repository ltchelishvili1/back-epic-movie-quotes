<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLikeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'quote_id' => 'required',
            'user_id' => 'required'
        ];
    }
    public function prepareForValidation()
    {
        $requestData = [
            'user_id' => auth()->user()->id,
            'quote_id' => $this->quote_id,
        ];
        $this->merge($requestData);
    }
}
