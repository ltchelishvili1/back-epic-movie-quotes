<?php

namespace App\Http\Requests;

use App\Models\Quote;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateQuoteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'quote' => 'nullable',
            'quote_en' => [
                'nullable',
                'regex:/^[a-zA-Z0-9\s]+$/',
                Rule::unique('quotes', 'quote->en')->ignore($this->quote_id),
            ],
            'quote_ka' => [
                'nullable',
                'regex:/^[ა-ჰ.,!?\s]*$/',
                Rule::unique('quotes', 'quote->ka')->ignore($this->quote_id),
            ],
            'image' => 'nullable',
            'quote_id' => 'required',
            'movie_id' => 'required',
        ];
    }

    public function prepareForValidation()
    {
        $quote = Quote::find($this->quote_id);

        $requestData = [
            'user_id' => auth()->user()->id,
            'quote' => [
                'en' => $this->quote_en ?? $quote->getTranslations('quote')['en'],
                'ka' => $this->quote_ka ?? $quote->getTranslations('quote')['ka'],
            ],
            'movie_id' => $quote->movie_id,
        ];


        $this->merge($requestData);
    }



}
