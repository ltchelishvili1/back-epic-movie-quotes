<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
            'comment' => 'required|string',
            'user_id' => 'required'
        ];

    }

    public function prepareForValidation()
    {

        $requestData = [
            'user_id' => auth()->user()->id,
            'quote_id' => $this->quote_id,
            'comment' => $this->comment
        ];

        $this->merge($requestData);
    }

}
