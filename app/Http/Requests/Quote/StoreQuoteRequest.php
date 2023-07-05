<?php

namespace App\Http\Requests\Quote;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuoteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'quote_en' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'quote_ka' => 'required|regex:/^[ა-ჰ0-9.,!?\s]*$/',
            'movie_id' => 'required|exists:movies,id',
            'image' => 'required|image|mimes:png,jpg|max:2048',
            'quote' => 'required',
            'user_id' => 'required'
        ];
    }


    public function prepareForValidation()
    {
        $this->merge([
            'quote' => [
                'en' => $this->quote_en,
                'ka' => $this->quote_ka,
            ],
            'user_id' => auth('sanctum')->id(),
        ]);
    }

}
