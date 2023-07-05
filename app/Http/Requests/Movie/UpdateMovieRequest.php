<?php

namespace App\Http\Requests\Movie;

use App\Models\Movie;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMovieRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */

    public function rules(): array
    {
        return [
            'title' => 'nullable',
            'director' => 'nullable',
            'description' => 'nullable',
            'title_en' => [
                'nullable',
                'regex:/^[a-zA-Z0-9\s]+$/',
                Rule::unique('movies', 'title->en')->ignore($this->id),
            ],
            'title_ka' => [
                'nullable',
                'regex:/^[ა-ჰ.,!?\s]*$/',
                Rule::unique('movies', 'title->ka')->ignore($this->id),
            ],
            'director_en' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'director_ka' => 'nullable|regex:/^[ა-ჰ.,!?\s]*$/',
            'release_year' => 'nullable',
            'description_ka' => 'nullable|regex:/^[ა-ჰ.,!?\s]*$/',
            'description_en' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'genres' => 'nullable',
            'thumbnail' => 'nullable',
        ];
    }

    public function prepareForValidation()
    {

        $requestData = [
            'user_id' => auth('sanctum')->id(),
            'director' => [
                'en' => $this->director_en,
                'ka' => $this->director_ka
            ],
            'description' => [
                'en' => $this->description_en,
                'ka' => $this->description_ka
            ],
            'title' => [
                'en' => $this->title_en,
                'ka' => $this->title_ka
            ],
        ];

        $this->merge($requestData);
    }


}
