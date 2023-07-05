<?php

namespace App\Http\Requests;

use App\Models\Quote;
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
            'user_id' => 'required',
            'author_id' => 'required',
            'type' => 'required'
        ];
    }
    public function prepareForValidation()
    {
        $requestData = [
            'user_id' => auth('sanctum')->id(),
            'quote_id' => $this->quote_id,
            'type' => 'like',
            'author_id' => Quote::find($this->quote_id)->user_id,
        ];
        $this->merge($requestData);
    }
}
