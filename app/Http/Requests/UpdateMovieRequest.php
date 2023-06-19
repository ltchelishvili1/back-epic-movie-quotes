<?php

namespace App\Http\Requests;

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
        $movie = Movie::find($this->id);

        $requestData = [
            'user_id' => auth()->user()->id,
            'director' => [
                'en' => $this->director_en ?? $movie->getTranslations('director')['en'],
                'ka' => $this->director_ka ?? $movie->getTranslations('director')['ka'],
            ],
            'description' => [
                'en' => $this->description_en ?? $movie->getTranslations('description')['en'],
                'ka' => $this->description_ka ?? $movie->getTranslations('description')['ka'],
            ],
            'title' => [
                'en' => $this->title_en ?? $movie->getTranslations('title')['en'],
                'ka' => $this->title_ka ?? $movie->getTranslations('title')['ka'],
            ],
        ];

        $this->merge($requestData);
    }


}
