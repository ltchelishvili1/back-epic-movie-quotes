<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'thumbnail' => $this->thumbnail,
            'id' => $this->id,
            'title' => $this->getTranslations('title'),
            'description' => $this->getTranslations('description'),
            'director' => $this->getTranslations('director'),
            'release_year' => $this->release_year,
            'quotes' => QuoteResource::collection($this->whenLoaded('quotes'))
        ];
    }
}
