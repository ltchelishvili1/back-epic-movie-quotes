<?php

namespace App\Http\Resources;

use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'image' => $this->image,
            'quote' => $this->getTranslations('quote'),
            'user' => [
                'id'        => $this->user->id,
                'username'  => $this->user->username,
                'thumbnail' => $this->user->thumbnail,
            ],
            'movie' => [
                'id'        => $this->movie->id,
                'title' => $this->movie->getTranslations('title'),
                'release_year' => $this->movie->release_year,
            ],
            'likes' =>  $this->likes,
            'comments' => $this->comments

        ];
    }
}
