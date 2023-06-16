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
            'image' => 'nullable',
        ];
    }

    public function prepareForValidation()
    {
        $requestData = [
            'user_id' => auth()->user()->id,
            'director' => json_decode($this->director, true),
            'description' => json_decode($this->description, true),
            'title' => json_decode($this->title, true),
        ];

        $movie = Movie::find($this->id);

        if ($this->title_en !== null || $this->title_ka !== null) {
            $requestData['title'] = [
                'en' => $this->title_en ?? $movie->getTranslations('title')['en'],
                'ka' => $this->title_ka ?? $movie->getTranslations('title')['ka'],
            ];
        }

        if ($this->director_en !== null || $this->director_ka !== null) {
            $requestData['director'] = [
                'en' => $this->director_en ?? $movie->getTranslations('director')['en'],
                'ka' => $this->director_ka ?? $movie->getTranslations('director')['ka'],
            ];
        }

        if ($this->description_en !== null || $this->description_ka !== null) {
            $requestData['description'] = [
                'en' => $this->description_en ?? $movie->getTranslations('description')['en'],
                'ka' => $this->description_ka ?? $movie->getTranslations('description')['ka'],
            ];
        }

        $this->merge($requestData);
    }

}
