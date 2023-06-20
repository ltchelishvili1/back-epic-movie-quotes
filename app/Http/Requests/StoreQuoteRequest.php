<?php

namespace App\Http\Requests;

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
            'quote_en' => 'required|regex:/^[a-zA-Z0-9\s]+$/|unique:quotes,quote->en',
            'quote_ka' => 'required|regex:/^[ა-ჰ.,!?\s]*$/|unique:quotes,quote->ka',
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
            'user_id' => auth()->user()->id,
        ]);
    }

}
