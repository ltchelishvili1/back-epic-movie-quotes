<?php

namespace App\Http\Requests;

use App\Models\Quote;
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
            'user_id' => 'required',
            'type' => 'required',
            'author_id' => 'required'
        ];

    }

    public function prepareForValidation()
    {

        $requestData = [
            'user_id' => auth('sanctum')->id(),
            'quote_id' => $this->quote_id,
            'comment' => $this->comment,
            'type' => 'comment',
            'author_id' => Quote::find($this->quote_id)->user_id,
        ];

        $this->merge($requestData);
    }

}
