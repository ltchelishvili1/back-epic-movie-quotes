<?php

namespace App\Http\Resources;

use App\Http\Resources\Movie\MovieResource;
use App\Http\Resources\Quote\QuoteResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'        => $this->id,
			'thumbnail' => $this->thumbnail,
			'username'  => $this->username,
			'email'     => $this->email,
			'google_id' => $this->google_id,
			'quotes'    => QuoteResource::collection($this->whenLoaded('quotes')),
			'movies'    => MovieResource::collection($this->whenLoaded('movies')),
			'likes'		   => $this->whenCounted('likes'),
			'comments'		=> $this->whenCounted('comments'),
		];
	}
}
