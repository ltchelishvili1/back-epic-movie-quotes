<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title'=> 'required',
            'director' => 'required',
            'description' => 'required',
            'title_en' => 'required|regex:/^[a-zA-Z0-9\s]+$/|unique:movies,title->en',
            'title_ka' => 'required|regex:/^[ა-ჰ.,!?\s]*$/|unique:movies,title->ka',
            'director_en' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'director_ka' => 'required|regex:/^[ა-ჰ.,!?\s]*$/',
            'release_year' => 'required',
            'description_ka' => 'required|regex:/^[ა-ჰ.,!?\s]*$/',
            'description_en' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'genres'=> 'required',
            'thumbnail' => 'required|image',
            'user_id' => 'required'
        ];

    }

    public function prepareForValidation()
    {
        $this->merge([
            'user_id' => auth()->user()->id,
            'title' => [
                'en' => $this->title_en,
                'ka' => $this->title_ka,
            ],
            'director' => [
                'en' => $this->director_en,
                'ka' => $this->director_ka,
            ],
            'description' => [
                'en' => $this->description_en,
                'ka' => $this->description_ka,
            ],

        ]);

    }

    public function messages(): array
    {
        return [
            'title_en.unique' => 'Movie already exists',
            'title_ka.unique' => 'Movie already exists',
        ];
    }
}
